<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/definition.php';

$spike = new \Issei\Spike\Spike(API_SECRET);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<h1>Retrieve the token</h1>';

$req = new \Issei\Spike\TokenRequest();
$req
    ->setCardNumber('4444333322221111')
    ->setExpirationMonth(12)
    ->setExpirationYear(19)
    ->setHolderName('Taro Spike')
    ->setSecurityCode('123')
    ->setCurrency('JPY')
    ->setEmail('test@example.jp')
;
dump($token = $spike->getToken($req));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<h1>New charge</h1>';

$req = new \Issei\Spike\ChargeRequest();
$req
    ->setAmount(100, 'JPY')
    ->setCard($token)
    ->addProduct(
        (new \Issei\Spike\Model\Product(uniqid('product-', true)))
            ->setTitle('Title')
            ->setDescription('Description')
            ->setCount(1)
            ->setPrice(100, 'USD')
            ->setLanguage('JA')
    )
;
dump($spike->charge($req));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<h1>Retrieve charges</h1>';

dump($charges = $spike->getCharges(5));

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

echo '<h1>Refund the charge</h1>';

dump($spike->refund($charges[0]));
