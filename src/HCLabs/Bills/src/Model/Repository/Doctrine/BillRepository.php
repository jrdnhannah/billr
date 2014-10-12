<?php

namespace HCLabs\Bills\Model\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;
use HCLabs\Bills\Model\Bill;

class BillRepository extends DoctrineRepository implements \HCLabs\Bills\Model\Repository\BillRepository
{
    /**
     * {@inheritdoc}
     */
    public function findBillsDue(\DateInterval $interval)
    {
        $now    = new \DateTime('now');
        $future = (new \DateTime('now'))->add($interval);

        return $this->createQueryBuilder('b')
                    ->where('b.dateDue >= :now')
                    ->andWhere('b.dateDue <= :future')
                    ->andWhere('b.datePaid is NULL')
                    ->setParameters(['now' => $now, 'future' => $future])
                    ->getQuery()
                    ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function save(Bill $bill)
    {
        $this->saveModel($bill);
    }
}