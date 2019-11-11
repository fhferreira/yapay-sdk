<?php

namespace Rockbuzz\SDKYapay\Payment;

class Items implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @var Item[]
     */
    public function __construct(array $items)
    {
        array_walk($items, function (Item $item) {
            $this->add($item);
        });
    }

    public function jsonSerialize()
    {
        return array_map(function (Item $item) {

            $dataItem =[
                'codigoProduto' => (string) $item->getProductId(),
                'nomeProduto' => (string) $item->getProductName(),
                'quantidadeProduto' => $item->getQuantity(),
                'valorUnitarioProduto' => $item->getPriceInCents(),
            ];

            if ($item->getCategoryId()) {
                $dataItem['codigoCategoria'] = $item->getCategoryId();
            }

            return $dataItem;
        }, $this->data);
    }

    protected function add(Item $item): void
    {
        array_push($this->data, $item);
    }
}
