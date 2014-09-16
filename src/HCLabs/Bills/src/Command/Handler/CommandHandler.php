<?php

namespace HCLabs\Bills\Command\Handler;

interface CommandHandler
{
    public function handle($command);

    /**
     * @return string
     */
    public function supports();

    /**
     * @return int
     */
    public function getPriority();
}