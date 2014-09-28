<?php

namespace HCLabs\Bills\Command;

use HCLabs\Bills\Model\Bill;

class PayBillCommand
{
    /** @var \HCLabs\Bills\Model\Bill */
    private $bill;

    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    /**
     * @return Bill
     */
    public function getBill()
    {
        return $this->bill;
    }
}