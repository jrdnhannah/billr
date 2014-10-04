<?php

namespace HCLabs\Bills\EventStore\DomainEvent;

interface DomainEvent
{
    /** @return int */
    public function getAggregateId();
}