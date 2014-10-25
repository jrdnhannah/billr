<?php

namespace HCLabs\Bills\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Value\CompanyName;

class LoadCompanyData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    function load(ObjectManager $manager)
    {
        $company = Company::createWithoutServices(
            new CompanyName('Virgin Media')
        );

        $this->setReference('company_vm', $company);
        $manager->persist($company);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    function getOrder()
    {
        return 1;
    }

}