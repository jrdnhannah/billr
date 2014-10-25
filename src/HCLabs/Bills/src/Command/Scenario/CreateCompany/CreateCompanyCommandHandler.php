<?php

namespace HCLabs\Bills\Command\Scenario\CreateCompany;

use HCLabs\Bills\Command\Handler\AbstractCommandHandler;
use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Model\Repository\CompanyRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateCompanyCommandHandler extends AbstractCommandHandler
{
    /** @var CompanyRepository */
    private $companyRepository;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param CompanyRepository $companyRepository
     */
    public function __construct(EventDispatcherInterface $dispatcher, CompanyRepository $companyRepository)
    {
        parent::__construct($dispatcher);
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param CreateCompanyCommand $command
     * @return void
     */
    public function handle($command)
    {
        $company = Company::createWithoutServices($command->getCompanyName());
        $this->companyRepository->save($company);
    }
}