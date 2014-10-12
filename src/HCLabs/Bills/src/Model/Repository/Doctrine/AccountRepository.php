<?php

namespace HCLabs\Bills\Model\Repository\Doctrine;

use HCLabs\Bills\Model\Account;

class AccountRepository extends DoctrineRepository implements \HCLabs\Bills\Model\Repository\AccountRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Account $account)
    {
        $this->saveModel($account);
    }
}