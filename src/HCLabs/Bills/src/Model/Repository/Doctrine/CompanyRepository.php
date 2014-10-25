<?php

namespace HCLabs\Bills\Model\Repository\Doctrine;

use HCLabs\Bills\Model\Company;

class CompanyRepository extends DoctrineRepository implements \HCLabs\Bills\Model\Repository\CompanyRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Company $company)
    {
        $this->saveModel($company);
    }

}