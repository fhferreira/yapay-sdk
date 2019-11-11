<?php

namespace Rockbuzz\SDKYapay\Payment;

class TransactionMultipleCreditCard extends BaseTransaction implements \JsonSerializable
{
    /**
     * @var int
     */
    private $installments;

    public function __construct(
        int $number,
        int $value,
        int $language,
        string $notificationUrl
    ) {
        parent::__construct($number, $value, $notificationUrl);
        $this->language = $language;
    }

    public function jsonSerialize()
    {
        return [
            'numeroTransacao' => $this->number,
            'valor' => $this->value,
            'idioma' => $this->language,
            'urlCampainha' => $this->notificationUrl
        ];
    }
}
