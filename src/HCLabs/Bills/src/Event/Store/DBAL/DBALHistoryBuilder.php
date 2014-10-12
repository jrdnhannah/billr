<?php

namespace HCLabs\Bills\Event\Store\DBAL;

use Doctrine\DBAL\Connection;
use HCLabs\Bills\Event\Store\HistoryBuilder;

class DBALHistoryBuilder implements HistoryBuilder
{
    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function build($aggregateId, $event)
    {
        // TODO: Implement build() method.
    }

}