<?php

namespace HCLabs\Bills\Exception;

class CommandAlreadyRegisteredException extends \Exception
{
    public function __construct($commandClass)
    {
        parent::__construct("The command {$commandClass} is already being handled");
    }
}