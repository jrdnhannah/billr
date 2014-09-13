<?php

namespace HCLabs\Bills\Billing\BillingPeriod;

class Quarterly extends BillingPeriod
{
    /**
     * {@inheritdoc}
     */
    public function getBillingIntervalString()
    {
        return 'P3M';
    }
}