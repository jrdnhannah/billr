<?php

namespace HCLabs\Bills\Exception;

class BillAlreadyPaidException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Bill already paid');
    }
}