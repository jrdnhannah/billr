<?php

namespace HCLabs\Bills\Exception;

class NoCommandHandlerFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No command handler was found');
    }
}