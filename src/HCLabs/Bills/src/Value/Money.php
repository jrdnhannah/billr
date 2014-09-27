<?php

namespace HCLabs\Bills\Value;

final class Money
{
    /** @var integer */
    private $amount;

    public function __construct($amount)
    {
        \Assert\that($amount)->float();
        $this->amount = (int) ($amount * 100);
    }

    /**
     * @return int
     */
    public function toInt()
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function toFloat()
    {
        return (float) ($this->amount * 0.01);
    }
}
