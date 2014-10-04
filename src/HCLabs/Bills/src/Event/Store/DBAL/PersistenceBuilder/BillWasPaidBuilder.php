<?php

namespace HCLabs\Bills\Event\Store\DBAL\PersistenceBuilder;

use Doctrine\DBAL\Schema\Schema;
use HCLabs\Bills\Event\Store\DBAL\DBALEventStoreSchemaBuilder;

class BillWasPaidBuilder implements DBALEventStoreSchemaBuilder
{
    public function build(Schema $schema)
    {
        $table = $schema->createTable('bill_was_paid');
        $table->addColumn('bill_id', 'integer', ['unsigned' => true]);
        $table->addColumn('date_paid', 'datetime');
        $table->setPrimaryKey(['bill_id']);
    }
}