Spike for PHP
=============

[![Build Status](https://travis-ci.org/issei-m/spike-php.svg)](https://travis-ci.org/issei-m/spike-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/issei-m/spike-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/issei-m/spike-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/issei-m/spike-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/issei-m/spike-php/?branch=master)
[![License](https://poser.pugx.org/issei-m/spike-php/license.svg)](https://packagist.org/packages/issei-m/spike-php)

The client of https://spike.cc REST api for PHP.  
**This library is in ALPHA version yet.**

Basic Usage
-----------

First, initialize the `Spike` object with your **api secret key**. It's the entry point for accessing the all api interface:

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

Tips: Refund needs only `Charge`'s id, so you can also use an initialized one by the id manually:

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
$ composer require issei-m/spike-php
```

Contributing
------------

1. Fork it
2. Create your feature branch
3. Commit your change and push it
4. Create a new pull request

[Composer]: https://getcomposer.org
