<?php

namespace HCLabs\Bills\Tests\Stub\Command\Handler;

use HCLabs\Bills\Command\Handler\CommandHandlerInterface;

class CommandHandler_stub implements CommandHandlerInterface
{
    public $handled = false;

    private $priority;

    /**
     * @param $priority
     */
    public function __construct($priority = 0)
    {
        $this->priority = $priority;
    }

    /**
     * {@inheritdoc}
     */
    public function handle($command)
    {
        $this->handled = true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports()
    {
        return 'HCLabs\Bills\Tests\Stub\Command\Command_stub';
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return $this->priority;
    }
}