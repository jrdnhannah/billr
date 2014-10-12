<?php

namespace HCLabs\Bills\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractCommandHandler implements CommandHandlerInterface
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * @param EventDispatcherInterface  $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    protected function dispatch($eventName, Event $event)
    {
        $this->dispatcher->dispatch($eventName, $event);
    }
}