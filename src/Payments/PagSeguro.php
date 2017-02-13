<?php

namespace BrPayments\Payments;

class PagSeguro
{
    protected $config;
    protected $sender;
    protected $shipping;
    protected $products;

    public function __construct(array $config)
    {
        $this->config = $config;

    }

    public function customer(...$customer)
    {
        $this->sender = [
            'senderName' => $customer[0],
            'senderAreaCode' => $customer[1],
            'senderPhone' => $customer[2],
            'senderEmail' => $customer[3],
        ];

    }

    public function shipping(...$shipping)
    {
        $this->shipping = [
            'shippingType' => $shipping[0],
            'shippingAddressStreet' => $shipping[1],
            'shippingAddressNumber' => $shipping[2],
            'shippingAddressComplement' => $shipping[3],
            'shippingAddressDistrict' => $shipping[4],
            'shippingAddressPostalCode' => $shipping[5],
            'shippingAddressCity' => $shipping[6],
            'shippingAddressState' => $shipping[7],
            'shippingAddressCountry' => $shipping[8],
        ];

    }

    public function addProduct(...$product)
    {
        $index = count($this->products);
        $this->products[$index] = [
            'id'=> $product[0],
            'description'=> $product[1],
            'amount'=> $product[2],
            'quantity'=> $product[3],
        ];
        if (!empty($product[4])) {
            $this->products[$index]['wheight'] = $product[4];
        }

    }

    public function removeProduct($id)
    {
        $products = array_filter($this->products, function ($product) use ($id) {

            return $product['id'] != $id;

        });
        $this->products = array_values($products);

    }

    public function __toString()
    {
        return http_build_query($this->toArray());

    }

    public function toArray()
    {
        $items = [];
        foreach ($this->products as $k => $product) {
            $counter = $k+1;
            $items['itemId'.$counter] = $product['id'];
            $items['itemDescription'.$counter] = $product['description'];
            $items['itemAmount'.$counter] = number_format($product['amount'], 2, '.', '');
            $items['itemQuantity'.$counter] = $product['quantity'];
            if (!empty($product['weight'])) {
                $items['itemWeight'.$counter] = $product['weight'];
            }
        }

        return array_merge($this->config, $items, $this->sender, $this->shipping);

    }
}
