<?php

namespace HCLabs\Bills\Command\Handler;

interface CommandHandler
{
    public function handle($command);
}