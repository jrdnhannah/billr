<?php

namespace HCLabs\Bills\Model;

class Account
{
    /** @var int */
    private $id;

    /** @var string */
    private $company;

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

    private function __construct()
    {
    }

    /**
     * Subscribe to a new service
     *
     * @param string    $company
     * @param string    $accountNumber
     * @param double    $recurringCharge
     * @param \DateTime $dateOpened
     * @param \DateTime $billingStartDate
     * @param int       $billingInterval
     * @param \DateTime $closureDate
     * @return \HCLabs\Bills\Model\Account
     */
    public static function subscribe($company, $accountNumber, $recurringCharge, \DateTime $dateOpened, \DateTime $billingStartDate = null, $billingInterval = 30, \DateTime $closureDate = null)
    {
        if (null === $billingStartDate) {
            $billingStartDate = $dateOpened;
        }

        $account = new Account;
        $account->company          = $company;
        $account->accountNumber    = $accountNumber;
        $account->recurringCharge  = $recurringCharge * 10;
        $account->dateOpened       = $dateOpened;
        $account->billingStartDate = $billingStartDate;
        $account->billingInterval  = $billingInterval;
        $account->dateClosed       = $closureDate;

        return $account;
    }

    /**
     * @param int $newCharge
     */
    public function increaseRecurringCharge($newCharge)
    {
        $this->recurringCharge = $newCharge;
    }

    /**
     * @param int $newCharge
     */
    public function decreaseRecurringCharge($newCharge)
    {
        $this->recurringCharge = $newCharge;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if (null === $this->dateClosed) {
            return true;
        }

        return new \DateTime('now') >= $this->dateClosed;
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @return int
     */
    public function getBillingInterval()
    {
        return $this->billingInterval;
    }

    /**
     * @return \DateTime
     */
    public function getBillingStartDate()
    {
        return $this->billingStartDate;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return \DateTime
     */
    public function getDateOpened()
    {
        return $this->dateOpened;
    }

    /**
     * @return int
     */
    public function getRecurringCharge()
    {
        return $this->recurringCharge;
    }
}