<?php

namespace HCLabs\Bills\Command;

use HCLabs\Bills\Value\BillId;

class PayBillCommand
{
    /** @var BillId */
    private $billId;

    public function __construct(BillId $billId)
    {
        $this->billId = ($billId);
    }

    /**
     * @return BillId
     */
    public function getBillId()
    {
        return $this->billId;
    }
}