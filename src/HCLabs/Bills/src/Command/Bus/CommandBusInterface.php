<?php

namespace HCLabs\Bills\Command\Bus;

use HCLabs\Bills\Command\Handler\CommandHandlerInterface;

interface CommandBusInterface
{
    /**
     * Add a command handler
     *
     * @param CommandHandlerInterface $handler
     * @param string         $commandToHandleClass
     * @return void
     */
    public function addHandler(CommandHandlerInterface $handler, $commandToHandleClass);

    /**
     * Execute a command using all registered handlers
     *
     * @param $command
     * @return void
     * @throws \HCLabs\Bills\Exception\NoCommandHandlerFoundException
     */
    public function execute($command);

    /**
     * @return CommandHandlerInterface[]
     */
    public function getHandlers();
}