<?php

namespace Rockbuzz\SDKYapay\Result;

class Success implements \JsonSerializable
{

    const BOLETO_IDS = [
        16	, //Itaú	Transferência	Itaú Shopline
        17	, //Itaú	Boleto Online	Itaú Shopline
        20	, //Banco do Brasil	Boleto	BBOnline
        21	, //Banco do Brasil	Transferência	BBOnline
        23	, //Banrisul	Transferência	Banricompras
        24	, //Banrisul	Parcelamento	Banricompras.com
        25	, //Banrisul	Pré Datado	Banricompras.com
        26	, //Banrisul	Boleto	Banricompras.com
        104,  //Bradesco	Transferência	Bradesco Shopfacil
        105,  //Bradesco	Boleto Online	Bradesco ShopFácil
        28	, //Banco do Brasil	Boleto Offline	Banco do Brasil
        29	, //Itaú	Boleto Offline	Itaú
        30	, //Bradesco	Boleto Offline	Bradesco
        34	, //Caixa Econômica Federal	Boleto Offline	Caixa Econômica Federal
        41	, //Santander	Boleto Offline	Santander
        48	, //Banco do Brasil	Boleto Offline com registro	Banco do Brasil
    ];

    const CARD_IDS = [
        170,//Visa	Crédito	Cielo API 3.0	Cielo	WebService
        171,//MasterCard	Crédito	Cielo API 3.0	Cielo	WebService
        172,//American Express	Crédito	Cielo API 3.0	Cielo	WebService
        173,//Elo	Crédito	Cielo API 3.0	Cielo	WebService
        174,//Diners	Crédito	Cielo API 3.0	Cielo	WebService
        175,//Discover	Crédito	Cielo API 3.0	Cielo	WebService
        176,//Aura	Crédito	Cielo API 3.0	Cielo	WebService
        177,//JCB	Crédito	Cielo API 3.0	Cielo	WebService
        178,//Maestro	Débito	Cielo API 3.0	Cielo	WebService
        179,//Visa Electron	Débito	Cielo API 3.0	Cielo	WebService
        180,//Hipercard	Crédito	Cielo API 3.0	Cielo	WebService
        185,//Credsystem	Crédito	E-Rede	Rede	WebService
        186,//Banescard	Crédito	E-Rede	Rede	WebService
        187,//Sorocred	Crédito	E-Rede	Rede	WebService
        188,//Cabal	Crédito	E-Rede	Rede	WebService
        189,//American Express	Crédito	E-Rede	Rede	WebService
        190,//Visa	Crédito	E-Rede	Rede	WebService
        191,//MasterCard	Crédito	E-Rede	Rede	WebService
        192,//Diners	Crédito	E-Rede	Rede	WebService
        193,//Hipercard	Crédito	E-Rede	Rede	WebService
        194,//Hiper	Crédito	E-Rede	Rede	WebService
        195,//JCB	Crédito	E-Rede	Rede	WebService
        196,//Credz	Crédito	E-Rede	Rede	WebService
        197,//Maestro	Débito	E-Rede	Rede	WebService
        198,//Visa Electron	Débito	E-Rede	Rede	WebService
        199,//Elo	Crédito	E-Rede	Rede	WebService
        270,//Visa	Crédito	GetNetWS	GetNet	WebService
        271,//MasterCard	Crédito	GetNetWS	GetNet	WebService
        272,//American Express	Crédito	GetNetWS	GetNet	WebService
        273,//Elo	Crédito	GetNetWS	GetNet	WebService
        274,//Maestro	Débito	GetNetWS	GetNet	WebService
        275,//Visa Electron	Débito	GetNetWS	GetNet	WebService
        276,//Hipercard	Crédito	GetNetWS	GetNet	WebService
        350,//Visa	Crédito	StoneWs	Stone	WebService
        351,//MasterCard	Crédito	StoneWs	Stone	WebService
        352,//Hipercard	Crédito	StoneWs	Stone	WebService
        353,//Elo	Crédito	StoneWs	Stone	WebService
        380,//Visa	Crédito	BinWS	Bin-FirstData	WebService
        381,//MasterCard	Crédito	BinWS	Bin-FirstData	WebService
        382,//Cabal	Crédito	BinWS	Bin-FirstData	WebService
        383,//Elo	Crédito	BinWS	Bin-FirstData	WebService
        384,//HiperCard	Crédito	BinWS	Bin-FirstData	WebService
        385,//Sorocred	Crédito	BinWS	Bin-FirstData	WebService
        386,//Hiper	Crédito	BinWS	Bin-FirstData	WebService
        999,//Multiplos Cartões	-	-	-	WebService
    ];

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
        return in_array($this->json->codigoFormaPagamento, self::BOLETO_IDS);
    }

    public function isCredidCard(): bool
    {
        return in_array($this->json->codigoFormaPagamento, self::CARD_IDS);
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
            'valorPago' => (isset($this->json) and isset($this->json->valorPago)) ? $this->json->valorPago : '',
            'parcelas' => (isset($this->json) and isset($this->json->parcelas)) ? $this->json->parcelas : '',
            'autorizacao' => (isset($this->json) and isset($this->json->autorizacao)) ? $this->json->autorizacao : '',
            'codigoTransacaoOperadora' => (isset($this->json) and isset($this->json->codigoTransacaoOperadora)) ? $this->json->codigoTransacaoOperadora : '',
            'urlPagamento' => (isset($this->json) and isset($this->json->urlPagamento)) ? $this->json->urlPagamento : '',
            'dataAprovacaoOperadora' => (isset($this->json) and isset($this->json->dataAprovacaoOperadora)) ? $this->json->dataAprovacaoOperadora : '',
        ];

        if ($this->isCredidCard() AND (!isset($this->json->multiploCartao) OR $this->json->multiploCartao == 0)) {

            $data = array_merge($data, [
                'nsu' => (isset($this->json) and isset($this->json->nsu)) ? $this->json->nsu : '',
                'mensagemVenda' => (isset($this->json) and isset($this->json->mensagemVenda)) ? $this->json->mensagemVenda : '',
                'cartoesUtilizados' => (isset($this->json) and isset($this->json->cartoesUtilizados)) ? $this->json->cartoesUtilizados[0] : '',                
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
