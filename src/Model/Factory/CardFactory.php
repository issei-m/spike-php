<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Card;

/**
 * Creates a new credit card object.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class CardFactory implements ObjectFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $creditCard = new Card();
        $creditCard
            ->setCardNumberLast4($data['last4'])
            ->setBrand($data['brand'])
            ->setExpirationMonth(intval($data['exp_month']))
            ->setExpirationYear(intval($data['exp_year']))
            ->setHolderName($data['name'])
        ;

        return $creditCard;
    }
}
