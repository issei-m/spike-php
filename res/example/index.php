<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/definition.php';

$spike = new \Issei\Spike\Spike(API_SECRET);

echo '<h1>New Charge</h1>';

$req = new \Issei\Spike\ChargeRequest();
$req
    ->setAmount(100, 'JPY')
    ->setCard(CARD_TOKEN)
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

echo '<h1>Retrieve Charges</h1>';

dump($spike->getCharges(5));
