<?php

namespace HCLabs\Bills\Event;

use HCLabs\Bills\Model\Bill;
use Symfony\Component\EventDispatcher\Event;

class BillHasBeenPaidEvent extends Event
{
    /** @var Bill */
    private $bill;

    /**
     * @param Bill $bill
     */
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