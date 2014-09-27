<?php

namespace HCLabs\Bills\Command;

use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\AccountId;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;

class OpenAccountCommand
{
    /** @var \HCLabs\Bills\Model\Service */
    private $service;

    /** @var AccountId */
    private $accountNumber;

    /** @var Money */
    private $recurringCharge;

    /** @var \DateTime */
    private $dateOpened;

    /** @var BillingPeriod */
    private $billingPeriod;

    public function __construct(
        Service $service,
        AccountId $accountNumber,
        Money $recurringCharge,
        \DateTime $dateOpened,
        BillingPeriod $billingPeriod
    ) {
        $this->service = $service;
        $this->accountNumber = $accountNumber;
        $this->recurringCharge = $recurringCharge;
        $this->dateOpened = $dateOpened;
        $this->billingPeriod = $billingPeriod;
    }

    /**
     * @return AccountId
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @return BillingPeriod
     */
    public function getBillingPeriod()
    {
        return $this->billingPeriod;
    }

    /**
     * @return \DateTime
     */
    public function getDateOpened()
    {
        return $this->dateOpened;
    }

    /**
     * @return Money
     */
    public function getRecurringCharge()
    {
        return $this->recurringCharge;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }
}