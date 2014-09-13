<?php

namespace HCLabs\Bills\Billing\BillingPeriod;

class Monthly extends BillingPeriod
{
    /**
     * {@inheritdoc}
     */
    public function getBillingIntervalString()
    {
        return 'P1M';
    }

}