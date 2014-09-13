<?php

namespace HCLabs\Bills\Billing\BillingPeriod;

abstract class BillingPeriod
{
    /**
     * @return \DateInterval
     */
    public function getBillingInterval()
    {
        return new \DateInterval($this->getBillingIntervalString());
    }

    /**
     * @return string
     */
    abstract public function getBillingIntervalString();
}