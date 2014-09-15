<?php

namespace HCLabs\Bills\Command\Bus;

use HCLabs\Bills\Command\Handler\CommandHandler;

interface CommandBusInterface
{
    /**
     * Add a command handler
     *
     * @param CommandHandler $handler
     * @return void
     */
    public function addHandler(CommandHandler $handler);

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