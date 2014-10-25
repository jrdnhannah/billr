<?php

namespace HCLabs\Bills\Command\Handler;

interface CommandHandlerInterface
{
    /**
     * @param object $command
     * @return void
     */
    public function handle($command);
}