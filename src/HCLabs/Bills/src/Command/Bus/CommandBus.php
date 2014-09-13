<?php

namespace HCLabs\Bills\Command\Bus;

use HCLabs\Bills\Command\Handler\CommandHandler;
use HCLabs\Bills\Exception\NoCommandHandlerFoundException;

class CommandBus implements CommandBusInterface
{
    /** @var CommandHandler[] */
    private $handlers;

    public function __construct()
    {
        $this->handlers = [];
    }

    /**
     * {@inheritdoc}
     */
    public function addHandler(CommandHandler $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command)
    {
        $handled = false;
        foreach ($this->handlers as $handler) {
            if ($handler->supports($command)) {
                $handler->handle($command);
                $handled = true;
            }
        }

        if(false === $handled) {
            throw new NoCommandHandlerFoundException;
        }
    }
}