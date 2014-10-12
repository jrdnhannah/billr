<?php

namespace HCLabs\Bills\Event;

use HCLabs\Bills\EventStore\DomainEvent\DomainEvent;
use HCLabs\Bills\Model\Bill;
use Symfony\Component\EventDispatcher\Event;

class BillHasBeenPaidEvent extends Event implements DomainEvent
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

    /** @return int */
    public function getAggregateId()
    {
        return $this->bill->getId();
    }
}