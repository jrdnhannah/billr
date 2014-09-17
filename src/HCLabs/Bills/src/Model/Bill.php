<?php

namespace HCLabs\Bills\Model;

class Bill
{
    /** @var int */
    private $id;

    /** @var int */
    private $amount;

    /** @var Account */
    private $account;

    /** @var \DateTime */
    private $dueDate;

    /** @var bool */
    private $paid;

    private function __construct()
    {
        $this->paid = false;
    }

    /**
     * @param Account $account
     * @param \DateTime $dueDate
     * @return Bill
     */
    public static function create(Account $account, \DateTime $dueDate)
    {
        $bill = new Bill;
        $bill->account = $account;
        $bill->amount  = $account->getRecurringCharge() * 10;
        $bill->dueDate = $dueDate;

        return $bill;
    }

    public function pay()
    {
        $this->paid = true;
    }
}