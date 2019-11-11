<?php

namespace Rockbuzz\SDKYapay\Result;

class Success implements \JsonSerializable
{
    const METHOD_BOLETO = 29;
    const METHOD_CREDITCARD = 170;
    const METHOD_MULTIPLE_CREDITCARDS = 999;

    /**
     * @var string
     */
    protected $json;

    public function __construct(string $json)
    {
        $this->json = json_decode($json);
    }

    public function isBoleto(): bool
    {
        return self::METHOD_BOLETO == $this->json->codigoFormaPagamento;
    }

    public function isCredidCard(): bool
    {
        try {
            if (isset($this->json->codigoFormaPagamento)) {
                return in_array($this->json->codigoFormaPagamento, [self::METHOD_CREDITCARD, self::METHOD_MULTIPLE_CREDITCARDS]);
            } else if ($this->json->multiploCartao == 1) {
                return true;
            }
        } catch (\Exception $e)  {
            dd($this->json, $e);
        }
    }

    public function jsonSerialize()
    {
        $data = [
            'numeroTransacao' => (isset($this->json) and isset($this->json->numeroTransacao)) ? $this->json->numeroTransacao : '',
            'statusTransacao' => (isset($this->json) and isset($this->json->statusTransacao)) ? $this->json->statusTransacao : '',
            'codigoFormaPagamento' => (isset($this->json) and isset($this->json->codigoFormaPagamento)) ? $this->json->codigoFormaPagamento : '',
            'codigoEstabelecimento' => (isset($this->json) and isset($this->json->codigoEstabelecimento)) ? $this->json->codigoEstabelecimento : '',
            'valor' => (isset($this->json) and isset($this->json->valor)) ? $this->json->valor : '',
            'valorDesconto' => (isset($this->json) and isset($this->json->valorDesconto)) ? $this->json->valorDesconto : '',
            'parcelas' => (isset($this->json) and isset($this->json->parcelas)) ? $this->json->parcelas : '',
            'autorizacao' => (isset($this->json) and isset($this->json->autorizacao)) ? $this->json->autorizacao : '',
            'codigoTransacaoOperadora' => (isset($this->json) and isset($this->json->codigoTransacaoOperadora)) ? $this->json->codigoTransacaoOperadora : '',
            'urlPagamento' => (isset($this->json) and isset($this->json->urlPagamento)) ? $this->json->urlPagamento : '',
        ];

        if ($this->isCredidCard() AND (!isset($this->json->multiploCartao) OR $this->json->multiploCartao == 0)) {
            $data = array_merge($data, [
                'nsu' => (isset($this->json) and isset($this->json->nsu)) ? $this->json->nsu : '',
                'mensagemVenda' => (isset($this->json) and isset($this->json->mensagemVenda)) ? $this->json->mensagemVenda : '',
                'cartoesUtilizados' => (isset($this->json) and isset($this->json->cartoesUtilizados)) ? $this->json->cartoesUtilizados : '',
                'dataAprovacaoOperadora' => (isset($this->json) and isset($this->json->dataAprovacaoOperadora)) ? $this->json->dataAprovacaoOperadora : '',
                'numeroComprovanteVenda' => (isset($this->json) and isset($this->json->numeroComprovanteVenda)) ? $this->json->numeroComprovanteVenda : '',
            ]);
        } else if ($this->isCredidCard() AND $this->json->multiploCartao == 1) {
            $data['nsu'] = '';
            $data['autorizacao'] = $this->json->detalhesMultiploCartao[0]->autorizacao;
            $data['codigoTransacaoOperadora'] = $this->json->detalhesMultiploCartao[0]->codigoTransacaoOperadora;
            $data['numeroComprovanteVenda'] = $this->json->detalhesMultiploCartao[0]->numeroComprovanteVenda;
            $data['mensagemVenda'] = $this->json->detalhesMultiploCartao[0]->mensagemVenda;
            $data['dataAprovacaoOperadora'] = $this->json->detalhesMultiploCartao[0]->dataAprovacaoOperadora;
        }

        return $data;
    }
}
