Spike for PHP
=============

[![Build Status](https://travis-ci.org/issei-m/spike-php.svg)](https://travis-ci.org/issei-m/spike-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/issei-m/spike-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/issei-m/spike-php/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/issei-m/spike-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/issei-m/spike-php/?branch=master)
[![License](https://poser.pugx.org/issei-m/spike-php/license.svg)](https://packagist.org/packages/issei-m/spike-php)

Latest release: [v1.0-BETA1](https://packagist.org/packages/issei-m/spike-php#v1.0-BETA1)

The client of https://spike.cc REST api for PHP (5.4+, HHVM).

Basic Usage
-----------

First, initialize the `Spike` object with your **api secret key**. It's the entry point for accessing the all api interfaces:

```php
$spike = new \Issei\Spike\Spike('your_api_secret_key');
```

### Create a new charge

To create a new charge, you have to build a `ChargeRequest` object. It can be specified `card token`, `amount`, `currency` and some related products. Next, call `charge()` method with it. If charge succeeded this method will return the new `Charge` object generated by REST api:

```php
$request = new \Issei\Spike\ChargeRequest();
$request
    ->setCard('tok_xxxxxxxxxxxxxxxxxxxxxxxx')
    ->setAmount(123.45, 'USD') // float
;

$product = new \Issei\Spike\Model\Product('my-product-00001'))
    ->setTitle('Product Name')
    ->setDescription('Description of Product.')
    ->setPrice(123.45, 'USD')
    ->setLanguage('EN')
    ->setCount(3)
    ->setStock(97)
;

$request->addProduct($product); // The product can be added many times.

/** @var $createdCharge \Spike\Model\Charge */
$createdCharge = $spike->charge($request);
```

**NOTE**: A `card token` cannot be retrieved from REST api, you have to retrieve it by [SPIKE Checkout] before using this interface.

### Find a charge

Call `getCharge()` method with charge id:

```php
/** @var $charge \Spike\Model\Charge */
$charge = $spike->getCharge('20150101-100000-xxxxxxxxxx');
```

### Refund the charge

Call `refund()` method with the `Charge` object that you want to refund:

```php
/** @var $charge \Spike\Model\Charge */
$refundedCharge = $spike->refund($charge);
```

Tips: Refund needs only `Charge`'s id, so you can also use an initialized one by the id manually:

```php
$charge = new \Spike\Model\Charge('20150101-100000-xxxxxxxxxx');
$refundedCharge = $spike->refund($charge);
```

### Retrieve the all charges

Call `getCharges()` method. it returns an array containing the `Charge` objects.

```php
/** @var $charges \Spike\Model\Charge[] */
$charges = $spike->getCharges();
```

#### Paging

You can specify the limit of number of records at 1st argument (10 records by default):

```php
$charges = $spike->getCharges(5);
```

If you pass a `Charge` object into 2nd argument, you can retrieve charges that older than that (passed charge is NOT included to list):

```php
$nextCharges = $spike->getCharges(5, $charges[count($charges) - 1]);
```

At 3rd argument, you can also specify the charge object if you want to retrieve charges that newer than that (passed charge is NOT included to list):

```php
$nextCharges = $spike->getCharges(5, $charges[count($charges) - 1], ...);
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

[SPIKE Checkout]: https://spike.cc/dashboard/developer/docs/references#a1
[Composer]: https://getcomposer.org
