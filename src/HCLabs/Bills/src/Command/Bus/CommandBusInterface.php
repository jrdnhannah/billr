<?php

namespace HCLabs\Bills\Command\Bus;

use HCLabs\Bills\Command\Handler\CommandHandler;

interface CommandBusInterface
{
    /**
     * Add a command handler
     *
     * @param CommandHandler $handler
     * @param string         $commandToHandleClass
     * @return void
     */
    public function addHandler(CommandHandler $handler, $commandToHandleClass);

    /**
     * Execute a command using all registered handlers
     *
     * @param $command
     * @return void
     * @throws \HCLabs\Bills\Exception\NoCommandHandlerFoundException
     */
    public function execute($command);

    /**
     * @return CommandHandler[]
     */
    public function getHandlers();
}