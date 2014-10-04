<?php

namespace HCLabs\Bills\Console;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use HCLabs\Bills\Event\Store\DBAL\DBALEventStoreSchemaBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDBALEventStore extends Command
{
    /** @var DBALEventStoreSchemaBuilder[] */
    private $schemaBuilders;

    /** @var Connection */
    private $connection;

    /**
     * The name and a list of the Domain Event classes
     *
     * @param string $name
     * @param string[] $schemaBuilders
     * @param Connection $connection
     */
    public function __construct($name = null, array $schemaBuilders, Connection $connection)
    {
        parent::__construct($name);
        $this->schemaBuilders = $schemaBuilders;
        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create the DBAL schema for the event store');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $schema = new Schema;
        $schemaManager = $this->connection->getSchemaManager();

        foreach ($this->schemaBuilders as $schemaBuilder) {
            $schemaBuilder->build($schema);
        }

        foreach ($schema->getTables() as $table) {
            $tableName = $table->getName();
            if (true === in_array($tableName, $schemaManager->listTableNames())) {
                $output->writeln("<info>Table {$tableName} already exists. Skipping.</info>");
                continue;
            }

            $output->writeln("<info>Creating table {$tableName}...</info>");
            $schemaManager->createTable($table);
        }
    }
}