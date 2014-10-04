<?php

namespace HCLabs\Bills\Aggregate;

use HCLabs\Bills\Event\BillWasPaid;
use HCLabs\Bills\Exception\BillAlreadyPaidException;
use HCLabs\Bills\Value\BillId;

class Bill extends Aggregate
{
    /** @var \DateTime */
    private $datePaid;

    public function pay(BillId $billId)
    {
        $this->recordThat(new BillWasPaid($billId, new \DateTime('now')));
    }

    /**
     * @param BillWasPaid $event
     */
    private function applyBillWasPaid(BillWasPaid $event)
    {
        $this->guardAgainstDoublePaying();
        $this->datePaid = $event->getDatePaid();
    }

    /**
     * @throws BillAlreadyPaidException
     */
    private function guardAgainstDoublePaying()
    {
        if (!!$this->datePaid) {
            throw new BillAlreadyPaidException;
        }
    }
}