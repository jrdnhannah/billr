<?php

namespace HCLabs\Bills\Command\Scenario\OpenAccount;

use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\AccountNumber;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;

class OpenAccountCommand
{
    /** @var \HCLabs\Bills\Model\Service */
    private $service;

    /** @var AccountNumber */
    private $accountNumber;

    /** @var Money */
    private $recurringCharge;

    /** @var \DateTime */
    private $dateOpened;

    /** @var BillingPeriod */
    private $billingPeriod;

    /**
     * @param Service $service
     * @param AccountNumber $accountNumber
     * @param Money $recurringCharge
     * @param \DateTime $dateOpened
     * @param BillingPeriod $billingPeriod
     */
    public function __construct(
        Service $service,
        AccountNumber $accountNumber,
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
     * @return AccountNumber
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