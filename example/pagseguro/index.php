<?php

require __DIR__.'/../../vendor/autoload.php';

$access = [
    'email'=>'erik.figueiredo@gmail.com',
    'token'=>'E7EF160DE74646CE80AB18EDDA257F1B',
    'currency'=>'BRL',
    'reference'=>'REF1234'
];

$pag_seguro = new BrPayments\Payments\PagSeguro($access);

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
$pag_seguro_request = new BrPayments\Requests\PagSeguro();

$response = (new BrPayments\MakeRequest())->post($pag_seguro, true);

$xml = new \SimpleXMLElement((string)$response);
$url = $pag_seguro_request->getUrlFinal($xml->code, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
</head>
<body>
    <button onclick="PagSeguroLightbox('<?php echo $xml->code;?>')">Pagar com lightbox</button>
    <a href="<?php echo $url;?>">Pagar com link padrão</a>
</body>
</html>
