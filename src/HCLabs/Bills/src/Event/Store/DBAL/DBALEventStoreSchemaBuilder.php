<?php

namespace HCLabs\Bills\Event\Store\DBAL;

use Doctrine\DBAL\Schema\Schema;

interface DBALEventStoreSchemaBuilder
{
    public function build(Schema $schema);
}