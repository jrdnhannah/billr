<?php

namespace HCLabs\Bills\Command\Scenario\CreateCompany;

class CreateCompanyCommand
{
    /** @var string */
    private $companyName;

    /**
     * @param string $companyName
     */
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }
}