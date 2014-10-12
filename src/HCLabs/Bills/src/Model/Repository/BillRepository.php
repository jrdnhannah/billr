<?php

namespace HCLabs\Bills\Model\Repository;

use HCLabs\Bills\Model\Bill;

interface BillRepository
{
    /**
     * Finds bills due with in the next x days,
     * x defined by the $interval
     *
     * @param   \DateInterval               $interval
     * @return  \HCLabs\Bills\Model\Bill[]
     */
    public function findBillsDue(\DateInterval $interval);

    /**
     * Saves the bill model
     *
     * @param Bill $bill
     * @return void
     */
    public function save(Bill $bill);
}