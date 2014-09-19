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
        $bill->amount  = $account->getRecurringCharge() * 10;
        $bill->dateDue = $dateDue;

        return $bill;
    }

    public function pay()
    {
        $this->datePaid = new \DateTime('now');
    }

    }
}