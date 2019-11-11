<?php

namespace Rockbuzz\SDKYapay\Payment;

class CreditCard implements \JsonSerializable
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

    public function __construct(
        string $holderName,
        int $number,
        int $securityCode,
        int $expirationMonth,
        int $expirationYear
    ) {
        $this->holderName = $holderName;
        $this->number = $number;
        $this->securityCode = $securityCode;
        $this->expirationMonth = $expirationMonth;
        $this->expirationYear = $expirationYear;
    }

    public function jsonSerialize()
    {
        $this->expirationMonth = str_pad($this->expirationMonth, 2, '0', STR_PAD_LEFT);

        return [
            'nomePortador' => $this->holderName,
            'numeroCartao' => (string) $this->number,
            'codigoSeguranca' => (string) $this->securityCode,
            'dataValidade' => "{$this->expirationMonth}/{$this->expirationYear}",
        ];
    }
}
