<?php

namespace HCLabs\Bills\Command\Scenario\CreateCompany;

use HCLabs\Bills\Value\CompanyName;

class CreateCompanyCommand
{
    /** @var CompanyName */
    private $companyName;

    /**
     * @param CompanyName $companyName
     */
    public function __construct(CompanyName $companyName)
    {
        $this->companyName = $companyName;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }
}