<?php

namespace Issei\Spike\Model\Factory;

use Issei\Spike\Util\DateTimeUtil;

/**
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
trait DateTimeUtilAwareTrait
{
    /**
     * @var DateTimeUtil
     */
    private $dateTimeUtil;

    public function __construct(DateTimeUtil $dateTimeUtil)
    {
        $this->dateTimeUtil = $dateTimeUtil;
    }
}
