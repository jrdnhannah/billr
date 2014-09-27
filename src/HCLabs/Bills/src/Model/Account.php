<?php

namespace HCLabs\Bills\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use HCLabs\Bills\Exception\InvalidDateIntervalSpecException;
use HCLabs\Bills\Value\AccountId;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;

class Account
{
    /** @var int */
    private $id;

    /** @var Service */
    private $service;

    /** @var string */
    private $accountNumber;

    /** @var int */
    private $recurringCharge;

    /** @var \DateTime */
    private $dateOpened;

    /** @var \DateTime */
    private $billingStartDate;

    /** @var int */
    private $billingInterval;

    /** @var \DateTime */
    private $dateClosed;

    /** @var Bill[]|Collection */
    private $bills;

    private function __construct()
    {
        $this->bills = new ArrayCollection;
    }

    /**
     * Subscribe to a new service
     *
     * @param Service        $service
     * @param AccountId      $accountNumber
     * @param Money          $recurringCharge
     * @param \DateTime      $dateOpened
     * @param \DateTime      $billingStartDate
     * @param BillingPeriod  $billingPeriod
     * @param \DateTime      $closureDate
     * @return \HCLabs\Bills\Model\Account
     */
    public static function open(
        Service $service,
        AccountId $accountNumber,
        Money $recurringCharge,
        \DateTime $dateOpened,
        BillingPeriod $billingPeriod,
        \DateTime $billingStartDate = null,
        \DateTime $closureDate = null
    ) {
        if (null === $billingStartDate) {
            $billingStartDate = $dateOpened;
        }

        if (null === $closureDate) {
            $closureDate = $dateOpened->add(new \DateInterval('P1Y'));
        }

        self::guardAgainstBadDateIntervalSpec($billingPeriod);

        $account = new Account;
        $account->service          = $service;
        $account->accountNumber    = (string) $accountNumber;
        $account->recurringCharge  = $recurringCharge->toInt();
        $account->dateOpened       = $dateOpened;
        $account->billingStartDate = $billingStartDate;
        $account->dateClosed       = $closureDate;
        $account->billingInterval  = (string) $billingPeriod;

        return $account;
    }

    /**
     * @param $billingPeriod
     * @throws InvalidDateIntervalSpecException
     */
    private static function guardAgainstBadDateIntervalSpec($billingPeriod)
    {
        try {
            new \DateInterval($billingPeriod);
        } catch (\Exception $e) {
            throw new InvalidDateIntervalSpecException;
        }
    }

    /**
     * @param double $amount
     */
    public function increaseRecurringCharge($amount)
    {
        $this->recurringCharge += ($amount * 100);
    }

    /**
     * @param double $amount
     */
    public function decreaseRecurringCharge($amount)
    {
        $this->recurringCharge -= ($amount * 100);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return new \DateTime('now') < $this->dateClosed;
    }

    /**
     * Schedule account closure date
     *
     * @param \DateTime $dateToClose
     * @return void
     */
    public function scheduleAccountClosure(\DateTime $dateToClose)
    {
        $this->dateClosed = $dateToClose;
    }

    /**
     * Close account immediately
     *
     * @return void
     */
    public function close()
    {
        $this->scheduleAccountClosure(new \DateTime('now'));
    }

    /**
     * @return \DateTime
     */
    public function dateToClose()
    {
        return $this->dateClosed;
    }

    /**
     * @return AccountId
     */
    public function getAccountNumber()
    {
        return new AccountId($this->accountNumber);
    }

    /**
     * @return \DateTime
     */
    public function getBillingStartDate()
    {
        return $this->billingStartDate;
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
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
        return Money::fromInteger((int) $this->recurringCharge);
    }

    /**
     * @return \DateInterval
     */
    public function getBillingInterval()
    {
        return new \DateInterval($this->billingInterval);
    }
}