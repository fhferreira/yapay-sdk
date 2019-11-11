<?php

namespace Rockbuzz\SDKYapay\Payment;

class Billing implements \JsonSerializable
{
    /**
     * @var Customer
     */
    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function jsonSerialize()
    {
        $data = [
            'codigoCliente' => (int) $this->customer->getId(),
            'nome' => (string) $this->customer->getName(),
            'documento' =>  (string) $this->customer->getDocument(),
            'email' => $this->customer->getEmail(),
        ];

        if ($this->customer->hasAddress()) {
            $data = array_merge(
                $data,
                [
                    'endereco' => [
                        'logradouro' => (string) $this->customer->getAddressStreet(),
                        'numero' => (string) $this->customer->getAddressNumber(),
                        'complemento' => (string) $this->customer->getAddressComplement(),
                        'cep' => (string) $this->customer->getAddressPostalCode(),
                        'bairro' => (string) $this->customer->getAddressNeighborhood(),
                        'cidade' => (string) $this->customer->getAddressCity(),
                        'estado' => (string) $this->customer->getAddressState(),
                        'pais' => (string) $this->customer->getAddressCountry(),
                    ],
                ]
            );
        }

        return $data;
    }
}
