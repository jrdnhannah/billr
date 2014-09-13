<?php
namespace HCLabs\Bills\Tests\Model;

use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Model\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_have_a_name_and_no_company()
    {
        $service = Service::fromName('Hammers for Rental');

        $this->assertNull($service->getCompany());
        $this->assertSame('Hammers for Rental', $service->getProvidedService());
    }

    /**
     * @test
     */
    public function it_should_have_a_name_and_company()
    {
        $company = Company::createWithoutServices('Acme');
        $service = Service::offer('Hammers for Rental', $company);

        $this->assertSame($company, $service->getCompany());
        $this->assertSame('Hammers for Rental', $service->getProvidedService());
    }
}
 