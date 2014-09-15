<?php

namespace HCLabs\Bills\Command\Handler;

interface CommandHandler
{
    public function handle($command);

    /**
     * @param string|object $class
     * @return bool
     */
    public function supports($class);

    /**
     * @return int
     */
    public function getPriority();
}