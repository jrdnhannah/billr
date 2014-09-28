<?php
namespace HCLabs\Bills\Tests\Model;

use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\CompanyName;
use HCLabs\Bills\Value\ProvidedService;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_have_a_name_and_no_company()
    {
        $service = Service::fromName(new ProvidedService('Hammers for Rental'));

        $this->assertNull($service->getCompany());
        $this->assertEquals(new ProvidedService('Hammers for Rental'), $service->getProvidedService());
    }

    /**
     * @test
     */
    public function it_should_have_a_name_and_company()
    {
        $company = Company::createWithoutServices(new CompanyName('FooBar'));
        $service = Service::offer(new ProvidedService('Hammers for Rental'), $company);

        $this->assertSame($company, $service->getCompany());
        $this->assertEquals(new ProvidedService('Hammers for Rental'), $service->getProvidedService());
    }
}
 