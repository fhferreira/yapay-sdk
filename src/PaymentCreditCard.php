<?php

namespace Rockbuzz\SDKYapay;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Rockbuzz\SDKYapay\Contract\Payment;
use Rockbuzz\SDKYapay\Exception\PaymentException;
use Rockbuzz\SDKYapay\Payment\Billing;
use Rockbuzz\SDKYapay\Payment\CreditCard;
use Rockbuzz\SDKYapay\Payment\Items;
use Rockbuzz\SDKYapay\Payment\TransactionCreditCard;

class PaymentCreditCard extends BasePayment implements Payment
{
    /**
     * @var TransactionCreditCard
     */
    protected $transaction;

    /**
     * @var CreditCard
     */
    protected $creditCard;

    public function __construct(
        Config $config,
        int $methodCode,
        TransactionCreditCard $transaction,
        CreditCard $creditCard,
        Items $items,
        Billing $billing
    ) {
        parent::__construct($config, $methodCode, $items, $billing);
        $this->transaction = $transaction;
        $this->creditCard = $creditCard;
    }

    public function done(ClientInterface $client = null): Result
    {
        try {
            return new Result($this->getContents($client ?? new Client()));
        } catch (\Exception $exception) {
            throw new Paymentexception(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }

    private function getContents(ClientInterface $client)
    {
        try {

            $body = json_encode([
                'codigoEstabelecimento' => $this->config->getStoreCode(),
                'codigoFormaPagamento'  => $this->methodCode,
                'transacao'             => $this->transaction,
                'dadosCartao'           => $this->creditCard,
                'itensDoPedido'         => $this->items,
                'dadosCobranca'         => $this->billing,
            ]);

            $response = $client->request('POST', $this->config->getEndpoint(), [
                'headers' => [
                    'Accept'          => 'application/json',
                    'Content-Type'    => 'application/json',
                    'Cache-Control'   => 'no-cache',
                    "accept-encoding" => "gzip, deflate",
                    'decode_content'  => false
                ],
                'auth'    => [
                    '0' => $this->config->getUsername(),
                    '1' => $this->config->getPassword(),
                ],
                'body'    => $body,
                'stream' => true
            ]);

            return $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            $body = $e->getResponse()->getBody();
            $response = $body->getContents();
            return $response;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $body = $e->getResponse()->getBody();
            $response = $body->getContents();
            return $response;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $body = $e->getResponse()->getBody();
            $response = $body->getContents();
            return $response;
        }  catch (\GuzzleHttp\Exception\ClientException $e) {
            $body = $e->getResponse()->getBody();
            $response = $body->getContents();
            return $response;
        }  catch (\GuzzleHttp\Exception\ConnectException $e) {
            $body = $e->getResponse()->getBody();
            $response = $body->getContents();
            return $response;
        }
    }
}
