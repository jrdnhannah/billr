<?php

namespace HCLabs\Bills\Event;

use HCLabs\Bills\Model\Account;
use Symfony\Component\EventDispatcher\Event;

class AccountWasOpenedEvent extends Event
{
    /** @var Account */
    private $account;

    /**
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}