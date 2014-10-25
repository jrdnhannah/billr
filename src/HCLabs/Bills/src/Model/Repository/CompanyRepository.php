<?php

namespace HCLabs\Bills\Model\Repository;

use HCLabs\Bills\Model\Company;

interface CompanyRepository
{
    /**
     * Saves the company model
     *
     * @param Company $company
     * @return void
     */
    public function save(Company $company);
}