<?php

namespace HCLabs\Bills\Event\Store\DBAL;

use Doctrine\DBAL\Connection;
use HCLabs\Bills\EventStore\DomainEvent\DomainEvent;

abstract class DBALPersister
{
    /** @var Connection */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param DomainEvent $event
     * @return void
     */
    abstract public function persist(DomainEvent $event);

    /**
     * @return Connection
     */
    protected function getConnection()
    {
        return $this->connection;
    }
}