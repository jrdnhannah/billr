<?php

namespace HCLabs\Bills\Event;

use HCLabs\Bills\EventStore\DomainEvent\DomainEvent;
use HCLabs\Bills\Value\BillId;

class BillWasPaid implements DomainEvent
{
    /** @var BillId */
    private $billId;

    /** @var \DateTime */
    private $datePaid;

    /**
     * @param BillId $billId
     * @param \DateTime $datePaid
     */
    public function __construct(BillId $billId, \DateTime $datePaid)
    {
        $this->billId = $billId;
        $this->datePaid = $datePaid;
    }

    /**
     * {@inheritdoc}
     */
    public function getAggregateId()
    {
        return $this->billId->toInt();
    }

    /**
     * @return \DateTime
     */
    public function getDatePaid()
    {
        return $this->datePaid;
    }
}