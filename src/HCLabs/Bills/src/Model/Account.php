<?php

namespace HCLabs\Bills\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use HCLabs\Bills\Billing\BillingPeriod\BillingPeriod;
use HCLabs\Bills\Exception\InvalidDateIntervalSpecException;

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
     * @param string         $accountNumber
     * @param double         $recurringCharge
     * @param \DateTime      $dateOpened
     * @param \DateTime      $billingStartDate
     * @param string         $billingPeriod
     * @param \DateTime      $closureDate
     * @return \HCLabs\Bills\Model\Account
     */
    public static function open(Service $service, $accountNumber, $recurringCharge, \DateTime $dateOpened, $billingPeriod, \DateTime $billingStartDate = null, \DateTime $closureDate = null)
    {
        if (null === $billingStartDate) {
            $billingStartDate = $dateOpened;
        }

        self::guardAgainstBadDateIntervalSpec($billingPeriod);

        $account = new Account;
        $account->service          = $service;
        $account->accountNumber    = $accountNumber;
        $account->recurringCharge  = $recurringCharge * 10;
        $account->dateOpened       = $dateOpened;
        $account->billingStartDate = $billingStartDate;
        $account->dateClosed       = $closureDate;
        $account->billingInterval  = $billingPeriod;

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
        $this->recurringCharge += ($amount * 10);
    }

    /**
     * @param double $amount
     */
    public function decreaseRecurringCharge($amount)
    {
        $this->recurringCharge -= ($amount * 10);
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if (null === $this->dateClosed) {
            return true;
        }

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
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
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
     * @return double
     */
    public function getRecurringCharge()
    {
        return $this->recurringCharge / 10;
    }
}