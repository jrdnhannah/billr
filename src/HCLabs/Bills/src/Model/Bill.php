<?php

namespace HCLabs\Bills\Model;

use HCLabs\Bills\Value\Money;

class Bill
{
    /** @var int */
    private $id;

    /** @var int */
    private $amount;

    /** @var Account */
    private $account;

    /** @var \DateTime */
    private $dateDue;

    /** @var \DateTime */
    private $datePaid;

    /**
     * @param Account $account
     * @param \DateTime $dateDue
     * @return Bill
     */
    public static function create(Account $account, \DateTime $dateDue)
    {
        $bill = new Bill;
        $bill->account = $account;
        $bill->amount  = $account->getRecurringCharge()->toInt();
        $bill->dateDue = $dateDue;

        return $bill;
    }

    public function pay()
    {
        $this->datePaid = new \DateTime('now');
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return Money
     */
    public function getAmountDue()
    {
        return Money::fromInteger($this->amount);
    }

    /**
     * @return bool
     */
    public function hasBeenPaid()
    {
        if (null === $this->datePaid) {
            return false;
        }

        return true;
    }
}