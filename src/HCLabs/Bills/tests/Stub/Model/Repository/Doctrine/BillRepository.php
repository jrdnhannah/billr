<?php

namespace HCLabs\Bills\Tests\Stub\Model\Repository\Doctrine;

use Doctrine\ORM\Mapping;
use HCLabs\Bills\Model\Bill;

class BillRepository extends InMemoryRepository implements \HCLabs\Bills\Model\Repository\BillRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Bill $bill)
    {
        $this->saveModel($bill);
    }

    /**
     * {@inheritdoc}
     */
    public function findBillsDue(\DateInterval $interval)
    {
        throw new \RuntimeException('Method findBillsDue not implemented');
    }

}