<?php

namespace HCLabs\Bills\Exception;

class InvalidDateIntervalSpecException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The supplied date interval spec was supplied in an invalid format.');
    }
}