<?php

namespace Rockbuzz\SDKYapay\Payment;

class MultipleCreditCard implements \JsonSerializable
{
    /**
     * @var string
     */
    private $holderName;

    /**
     * @var int
     */
    private $number;

    /**
     * @var int
     */
    private $securityCode;

    /**
     * @var int
     */
    private $expirationMonth;

    /**
     * @var int
     */
    private $expirationYear;

    /**
     * @var int
     */
    private $paymentMethodCode;

    /**
     * @var int
     */
    private $installments;

    /**
     * @var float
     */
    private $amount;

    public function __construct(
        string $holderName,
        int $number,
        int $securityCode,
        int $expirationMonth,
        int $expirationYear,
        int $paymentMethodCode,
        float $amount,
        int $installments = 1
    ) {
        $this->holderName = $holderName;
        $this->number = $number;
        $this->securityCode = $securityCode;
        $this->expirationMonth = $expirationMonth;
        $this->expirationYear = $expirationYear;
        $this->paymentMethodCode = $paymentMethodCode;
        $this->installments = $installments;
        $this->amount = $amount;
    }

    public function jsonSerialize()
    {
        $this->expirationMonth = str_pad($this->expirationMonth, 2, '0', STR_PAD_LEFT);

        return [
            'nomePortador' => $this->holderName,
            'numeroCartao' => (string) $this->number,
            'codigoSeguranca' => (string) $this->securityCode,
            'codigoFormaPagamento' => $this->paymentMethodCode,
            'parcelas' => $this->installments,
            'valor' => $this->amount,
            'dataValidade' => sprintf('%s/%s', $this->expirationMonth, $this->expirationYear),
        ];
    }
}
