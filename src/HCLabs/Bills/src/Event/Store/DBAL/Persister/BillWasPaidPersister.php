<?php

namespace HCLabs\Bills\Event\Store\DBAL\Persister;

use HCLabs\Bills\Event\Store\DBAL\DBALPersister;
use HCLabs\Bills\EventStore\DomainEvent\DomainEvent;

class BillWasPaidPersister extends DBALPersister
{
    public function persist(DomainEvent $event)
    {
        $reflection = new \ReflectionObject($event);
        $idProperty = $reflection->getProperty('billId');
        $datePaidProperty = $reflection->getProperty('datePaid');

        $idProperty->setAccessible(true);
        $datePaidProperty->setAccessible(true);

        $id       = $idProperty->getValue($event)->toInt();
        $datePaid = $datePaidProperty->getValue($event);

        $statement = $this
            ->getConnection()
            ->prepare('INSERT INTO bill_was_paid (bill_id, date_paid) VALUES (?, ?)');

        $statement->bindValue('1', $id);
        $statement->bindValue('2', $datePaid, 'datetime');
        $statement->execute();
    }
}