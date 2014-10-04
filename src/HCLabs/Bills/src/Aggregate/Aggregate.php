<?php

namespace HCLabs\Bills\Aggregate;

use HCLabs\Bills\EventStore\DomainEvent\DomainEvent;

abstract class Aggregate
{
    /** @var DomainEvent[] */
    private $recordedEvents = [];

    /** @var int */
    private $id;

    /**
     * @param int $id
     */
    protected function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param AggregateHistory $history
     */
    public static function reconstituteFromAggregateHistory(AggregateHistory $history)
    {
        /** @var Aggregate $aggregate */
        $aggregateId = $history->getAggregateId();
        $self        = get_called_class();
        $aggregate   = new $self($aggregateId);

        foreach ($history->getEventHistory() as $event) {
            $aggregate->apply($event);
        }
    }

    /**
     * @param DomainEvent $event
     */
    protected function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
        $this->apply($event);
    }

    /**
     * @param DomainEvent $event
     */
    private function apply(DomainEvent $event)
    {
        $method = 'apply' . $this->getClassForEventWithoutNamespace($event);
        $this->guardAgainstInvalidMethod($method);

        $this->$method($event);
    }

    /**
     * @param DomainEvent $event
     * @return string
     */
    private function getClassForEventWithoutNamespace(DomainEvent $event)
    {
        $classParts = explode('\\', get_class($event));
        return end($classParts);
    }

    /**
     * @param string $method
     */
    private function guardAgainstInvalidMethod($method)
    {
        if (false === method_exists($this, $method)) {
            $class = get_class($this);
            throw new \RuntimeException("Method {$method} does not exist in class {$class}.");
        }
    }

    /**
     * @return \HCLabs\Bills\EventStore\DomainEvent\DomainEvent[]
     */
    public function getRecordedEvents()
    {
        return $this->recordedEvents;
    }
}