<?php

namespace HCLabs\Bills\Tests\Stub\Command\Handler;

use HCLabs\Bills\Command\Handler\CommandHandler;

class CommandHandler_stub implements CommandHandler
{
    public $handled = false;

    public function handle($command)
    {
        $this->handled = true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($class)
    {
        return $class === 'foo';
    }

}