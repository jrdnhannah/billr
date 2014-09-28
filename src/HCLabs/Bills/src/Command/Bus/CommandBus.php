<?php

namespace HCLabs\Bills\Command\Bus;

use HCLabs\Bills\Command\Handler\CommandHandlerInterface;
use HCLabs\Bills\Exception\CommandAlreadyRegisteredException;
use HCLabs\Bills\Exception\NoCommandHandlerFoundException;

class CommandBus implements CommandBusInterface
{
    /** @var CommandHandlerInterface[] */
    private $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * {@inheritdoc}
     */
    public function addHandler(CommandHandlerInterface $handler, $commandToHandleClass)
    {
        $this->guardAgainstDuplicateCommand($commandToHandleClass);

        $this->handlers[$commandToHandleClass] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command)
    {
        $commandClass = get_class($command);
        $this->guardAgainstUnregisteredCommand($commandClass);

        $this->handlers[$commandClass]->handle($command);
    }

    /**
     * {@inheritdoc}
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * @param  string $commandToHandleClass
     * @throws CommandAlreadyRegisteredException
     */
    private function guardAgainstDuplicateCommand($commandToHandleClass)
    {
        if (isset($this->handlers[$commandToHandleClass])) {
            throw new CommandAlreadyRegisteredException($commandToHandleClass);
        }
    }

    /**
     * @param  string $commandClass
     * @throws NoCommandHandlerFoundException
     */
    private function guardAgainstUnregisteredCommand($commandClass)
    {
        if (false === isset($this->handlers[$commandClass])) {
            throw new NoCommandHandlerFoundException;
        }
    }
}