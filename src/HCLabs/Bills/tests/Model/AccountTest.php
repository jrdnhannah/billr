<?php

namespace HCLabs\Bills\Tests\Model;

use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Model\Service;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Service
     */
    private function createServicesAndCompany()
    {
        $company = Company::createWithoutServices('Acme');
        return Service::offer('Hammers for Rental', $company);
    }

    /**
     * @test
     */
    public function it_should_subscribe_using_default_parameters()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly());

        $this->assertSame('1234', $account->getAccountNumber());
        $this->assertSame(50.00, $account->getRecurringCharge());
        $this->assertSame($dateOpened, $account->getDateOpened());
        $this->assertSame($dateOpened, $account->getBillingStartDate());
    }

    /**
     * @test
     */
    public function it_should_increase_recurring_charge()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly());

        $account->increaseRecurringCharge(25.00);

        $this->assertEquals(75.00, $account->getRecurringCharge());
    }

    /**
     * @test
     */
    public function it_should_decrease_recurring_charge()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly());

        $account->decreaseRecurringCharge(10.00);

        $this->assertEquals(40.00, $account->getRecurringCharge());
    }

    /**
     * @test
     */
    public function it_should_not_be_active_if_the_closing_date_is_today_or_earlier()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly(), null, $dateOpened);

        $this->assertFalse($account->isActive());


        $closingDate = $dateOpened->sub(new \DateInterval('P30D'));
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly(), null, $closingDate);

        $this->assertFalse($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_be_active_without_a_closing_date()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly(), null);

        $this->assertTrue($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_be_active_with_a_later_closing_date()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open($this->createServicesAndCompany(), '1234', 50.00, $dateOpened, new Monthly(), $dateOpened->add(new \DateInterval('P3D')));

        $this->assertTrue($account->isActive());
    }
}
 