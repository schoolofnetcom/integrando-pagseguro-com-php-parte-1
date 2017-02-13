<?php

namespace BrPayments;

class MakeRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testPagSeguroRequest()
    {
        $access = [
            'email'=>'erik.figueiredo@gmail.com',
            'token'=>'E7EF160DE74646CE80AB18EDDA257F1B',
            'currency'=>'BRL',
            'reference'=>'REF1234'
        ];

        $pag_seguro = new Payments\PagSeguro($access);

        //name, areacode, phone, email
        $pag_seguro->customer('Jose Comprador', 11, 99999999, 'c75336791632449484854@sandbox.pagseguro.com.br');

        //type, street, number, complement, district, postal code, city, state, country
        $pag_seguro->shipping(
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
        $pag_seguro->addProduct(1, 'Curso de PHP', 19.99, 20);
        $pag_seguro->addProduct(2, 'Livro de Laravel', 15, 31, 1.5);

        //requisição
        $pag_seguro_request = new Requests\PagSeguro();

        $response = (new MakeRequest())->post($pag_seguro, true);

        $xml = new \SimpleXMLElement((string)$response);
        $url = $pag_seguro_request->getUrlFinal($xml->code, true);

        $this->assertTrue(is_string($url));
    }
}
