<?php

namespace HCLabs\Bills\Tests\Model;

use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\CompanyName;
use HCLabs\Bills\Value\ProvidedService;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_have_a_name_and_offer_two_services()
    {
        $services = [
            Service::fromName(new ProvidedService('Hammers for Renting')),
            Service::fromName(new ProvidedService('Saws for Renting'))
        ];

        $company = Company::createAndOfferServices(
            new CompanyName('Acme'),
            $services
        );

        $this->assertEquals(new CompanyName('Acme'), $company->getName());
        $this->assertEquals($services, $company->getOfferedServices()->toArray());
    }

    /**
     * @test
     */
    public function it_should_be_able_to_offer_services_after_instantiation()
    {
        $company = Company::createWithoutServices(new CompanyName('Acme'));

        $this->assertEquals(new \Doctrine\Common\Collections\ArrayCollection, $company->getOfferedServices());

        $service = Service::offer(
            new ProvidedService('Hammers for Renting'),
            $company
        );
        $company->offerService($service);

        $services = new \Doctrine\Common\Collections\ArrayCollection([$service]);

        $this->assertEquals($services, $company->getOfferedServices());
    }
}
 