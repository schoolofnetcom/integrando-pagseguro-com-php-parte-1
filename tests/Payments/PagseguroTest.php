<?php

namespace BrPayments\Payments;

class PagSeguroTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $access = [
            'email'=>'email@email',
            'token'=>'token',
            'currency'=>'BRL',
            'reference'=>'REF1234'
        ];

        $this->pag_seguro = new PagSeguro($access);

        //name, areacode, phone, email
        $this->pag_seguro->customer('Jose Comprador', 11, 99999999, 'comprador@comprador.com.br');

        //type, street, number, complement, district, postal code, city, state, country
        $this->pag_seguro->shipping(
            1,
            'Av. PagSeguro',
            99,
            '99o andar',
            'Jardim Internet',
            99999999,
            'Cidade Exemplo',
            'SP',
            'ATA'
        );

        //id, description, amount, quantity, wheight(optional)
        $this->pag_seguro->addProduct(1, 'Curso de PHP', 19.99, 20);
        $this->pag_seguro->addProduct(2, 'Livro de Laravel', 15, 31, 1.5);
    }

    public function testListarProdutosAdicionadosEmUmArray()
    {
        $actual = $this->pag_seguro->toArray();
        $expected = [
            'email'=>'email@email',
            'token'=>'token',
            'currency'=>'BRL',
            'reference'=>'REF1234',
            'itemId1'=>1,
            'itemDescription1'=>'Curso de PHP',
            'itemAmount1'=>'19.99',
            'itemQuantity1'=>20,
            'itemId2'=>2,
            'itemDescription2'=>'Livro de Laravel',
            'itemAmount2'=>'15.00',
            'itemQuantity2'=>31,
            'senderName'=>'Jose Comprador',
            'senderAreaCode'=>11,
            'senderPhone'=>99999999,
            'senderEmail'=>'comprador@comprador.com.br',
            'shippingType'=>1,
            'shippingAddressStreet'=>'Av. PagSeguro',
            'shippingAddressNumber'=>99,
            'shippingAddressComplement'=>'99o andar',
            'shippingAddressDistrict'=>'Jardim Internet',
            'shippingAddressPostalCode'=>99999999,
            'shippingAddressCity'=>'Cidade Exemplo',
            'shippingAddressState'=>'SP',
            'shippingAddressCountry'=>'ATA',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testRemoverProduto()
    {
        $this->pag_seguro->removeProduct(2);
        $actual = $this->pag_seguro->toArray();
        $expected = [
            'email'=>'email@email',
            'token'=>'token',
            'currency'=>'BRL',
            'reference'=>'REF1234',
            'itemId1'=>1,
            'itemDescription1'=>'Curso de PHP',
            'itemAmount1'=>'19.99',
            'itemQuantity1'=>20,
            'senderName'=>'Jose Comprador',
            'senderAreaCode'=>11,
            'senderPhone'=>99999999,
            'senderEmail'=>'comprador@comprador.com.br',
            'shippingType'=>1,
            'shippingAddressStreet'=>'Av. PagSeguro',
            'shippingAddressNumber'=>99,
            'shippingAddressComplement'=>'99o andar',
            'shippingAddressDistrict'=>'Jardim Internet',
            'shippingAddressPostalCode'=>99999999,
            'shippingAddressCity'=>'Cidade Exemplo',
            'shippingAddressState'=>'SP',
            'shippingAddressCountry'=>'ATA',
        ];

        $this->assertEquals($expected, $actual);
    }

    public function testListarProdutosAdicionadosEmUmaString()
    {
        $actual = (string)$this->pag_seguro;
        $this->assertTrue(is_string($actual));
    }
}
