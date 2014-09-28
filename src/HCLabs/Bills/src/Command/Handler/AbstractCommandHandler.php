<?php

namespace HCLabs\Bills\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractCommandHandler implements CommandHandlerInterface
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * @param EventDispatcherInterface  $dispatcher
     * @param EntityManagerInterface    $em
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManagerInterface $em)
    {
        $this->dispatcher = $dispatcher;
        $this->em         = $em;
    }

    protected function dispatch($eventName, Event $event)
    {
        $this->dispatcher->dispatch($eventName, $event);
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->em;
    }
}