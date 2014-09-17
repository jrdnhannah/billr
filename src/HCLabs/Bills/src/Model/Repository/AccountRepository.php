<?php

namespace HCLabs\Bills\Model\Repository;

interface AccountRepository
{
    /**
     * @return \HCLabs\Bills\Model\Account[]
     */
    public function findAll();
}