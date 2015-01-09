Spike
=====

[![Build Status](https://travis-ci.org/issei-m/spike.svg)](https://travis-ci.org/issei-m/spike)
[![Coverage Status](https://coveralls.io/repos/issei-m/spike/badge.png?branch=coveralls)](https://coveralls.io/r/issei-m/spike?branch=coveralls)
[![License](https://poser.pugx.org/issei-m/spike/license.svg)](https://packagist.org/packages/issei-m/spike)

Handles https://spike.cc REST api.  
**This library is in ALPHA version yet.**

Basic Usage
-----------

First, initialize the `Spike` object by your **api secret key**. It's the entry point for accessing the all api interface.

```php
$spike = new \Issei\Spike\Spike('your_api_secret_key');
```

### Find a charge by id:

```php
/** @var $charge \Spike\Model\Charge */
$charge = $spike->getCharge('charge_id');
```

### Create a new charge:

```php
$request = new \Issei\Spike\ChargeRequest();
$request
    ->setCard('retrieved_card_token')
    ->setAmount(150.0) // float
    ->setCurrency('USD')
;    

$product = new \Issei\Spike\Model\Product('unique_product_identifier'))
    ->setTitle('Product Name')
    ->setDescription('Description of Product.')
    ->setPrice(150.0) // float
    ->setCurrency('USD')
    ->setLanguage('EN')
    ->setCount(3) // integer
    ->setStock(97) // integer
;

$request->addProduct($product); // The product can be added many times.

/** @var $createdCharge \Spike\Model\Charge[] */
$createdCharge = $spike->charge($request);
```

### Refund the charge:

```php
/** @var $charge \Spike\Model\Charge */
$refundedCharge = $spike->refund($charge);
```

Note: Refunding needs only `Charge`'s id. So you can also use a manually initialized one by id to refund:

```php
$charge = new \Spike\Model\Charge('charge_identifier');
$refundedCharge = $spike->refund($charge);
```

### Retrieve the recent charges:

```php
/** @var $charges \Spike\Model\Charge[] */
$charges = $spike->getCharges();

// You can also specify the limit of number of records. (default by 10 records)
$charges = $spike->getCharges(5);
```

Installation
------------

Use [Composer] to install the package:

```
$ composer require issei-m/spike
```

Contributing
------------

1. Fork it
2. Create your feature branch
3. Commit your change and push it
4. Create a new pull request

[Composer]: https://getcomposer.org
[@Issei_M]: https://twitter.com/Issei_M
