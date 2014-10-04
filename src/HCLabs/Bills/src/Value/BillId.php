<?php

namespace HCLabs\Bills\Value;

class BillId
{
    /** @var int */
    private $billId;

    /**
     * @param int $billId
     */
    public function __construct($billId)
    {
        $this->billId = $billId;
    }

    /**
     * @return int
     */
    public function toInt()
    {
        return $this->billId;
    }
}