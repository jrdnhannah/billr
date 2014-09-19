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
    private $dateDue;

    /** @var bool */
    private $paid;

    private function __construct()
    {
        $this->paid = false;
    }

    /**
     * @param Account $account
     * @param \DateTime $dateDue
     * @return Bill
     */
    public static function create(Account $account, \DateTime $dateDue)
    {
        $bill = new Bill;
        $bill->account = $account;
        $bill->amount  = $account->getRecurringCharge() * 10;
        $bill->dateDue = $dateDue;

        return $bill;
    }

    public function pay()
    {
        $this->paid = true;
    }
}