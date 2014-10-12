<?php

namespace HCLabs\Bills\Model\Repository;

use HCLabs\Bills\Model\Account;

interface AccountRepository
{
    /**
     * @return \HCLabs\Bills\Model\Account[]
     */
    public function findAll();

    /**
     * Save the account model
     *
     * @param Account $account
     * @return void
     */
    public function save(Account $account);
}