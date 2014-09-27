<?php

namespace HCLabs\Bills\Value;

use HCLabs\Bills\Exception\InvalidDateIntervalSpecException;

class BillingPeriod
{
    /** @var string */
    private $billingPeriod;

    /**
     * @param string $billingPeriod
     * @throws InvalidDateIntervalSpecException
     */
    public function __construct($billingPeriod)
    {
        try {
            new \DateInterval($billingPeriod);
        } catch (\Exception $e) {
            throw new InvalidDateIntervalSpecException;
        }

        $this->billingPeriod = $billingPeriod;
    }

    /**
     * @return \DateInterval
     */
    public function toDateInterval()
    {
        return new \DateInterval($this->billingPeriod);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->billingPeriod;
    }
}