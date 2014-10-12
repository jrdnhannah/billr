<?php

namespace HCLabs\Bills\Event\Store;

interface HistoryBuilder
{
    public function build($aggregateId, $event);
}