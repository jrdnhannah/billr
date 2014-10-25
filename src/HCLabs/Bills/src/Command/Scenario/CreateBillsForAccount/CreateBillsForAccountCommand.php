<?php

namespace HCLabs\Bills\Command\Scenario\CreateBillsForAccount;

use HCLabs\Bills\Model\Account;

class CreateBillsForAccountCommand
{
    /** @var \HCLabs\Bills\Model\Account */
    private $account;

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