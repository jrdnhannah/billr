<?php

namespace HCLabs\Bills\Tests\Stub\Model\Repository\Doctrine;

use HCLabs\Bills\Model\Account;

class AccountRepository extends InMemoryRepository implements \HCLabs\Bills\Model\Repository\AccountRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Account $account)
    {
        $this->saveModel($account);
    }

}