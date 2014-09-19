<?php

namespace HCLabs\Bills\Model\Repository;

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
}