<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Model\Token;

/**
 * Creates a new token object.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class TokenFactory implements ObjectFactoryInterface
{
    use DateTimeUtilAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $token = new Token($data['id']);
        $token
            ->setCreated($this->dateTimeUtil->createDateTimeByUnixTime($data['created']))
            ->setSource($data['source'])
        ;

        return $token;
    }
}
