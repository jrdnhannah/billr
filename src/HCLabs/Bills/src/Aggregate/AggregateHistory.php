<?php

namespace HCLabs\Bills\Aggregate;

use HCLabs\Bills\EventStore\DomainEvent\DomainEvent;

class AggregateHistory
{
    /** @var DomainEvent[] */
    private $events = [];

    /** @var int */
    private $aggregateId;

    /**
     * @return int
     */
    public function getAggregateId()
    {
        return $this->aggregateId;
    }

    /**
     * @return DomainEvent[]
     */
    public function getEventHistory()
    {
        return $this->events;
    }

    /**
     * @param AggregateHistory $history
     */
    public function merge(AggregateHistory $history)
    {
        $this->events = array_merge($this->events, $history->getEventHistory());
    }
}