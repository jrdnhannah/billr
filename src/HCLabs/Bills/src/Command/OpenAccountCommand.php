<?php

namespace HCLabs\Bills\Command;

class OpenAccountCommand
{
    /** @var \HCLabs\Bills\Model\Service */
    public $service;

    /** @var string */
    public $accountNumber;

    /** @var double */
    public $recurringCharge;

    /** @var \DateTime */
    public $dateOpened;

    /** @var \DateInterval */
    public $billingPeriod;
}