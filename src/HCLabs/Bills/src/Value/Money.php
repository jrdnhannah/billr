<?php

namespace HCLabs\Bills\Value;

final class Money
{
    /** @var integer */
    private $amount;

    /**
     * @param int $amount
     */
    private function __construct($amount)
    {
        \Assert\that($amount)->integer();
        $this->amount = $amount;
    }

    /**
     * @param  int $amount
     * @return Money
     */
    public static function fromInteger($amount)
    {
        return new self($amount);
    }

    /**
     * @param  float $amount
     * @return Money
     */
    public static function fromFloat($amount)
    {
        \Assert\that($amount)->float();
        return new self((int) ($amount * 100));
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
