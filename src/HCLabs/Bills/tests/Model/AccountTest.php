<?php

namespace HCLabs\Bills\Tests\Model;

use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Company;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Service
     */
    private function createServicesAndCompany()
    {
        $company = Company::createWithoutServices(new Value\CompanyName('Acme'));
        return Service::offer(new Value\ProvidedService('Hammers for Rental'), $company);
    }

    /**
     * @test
     */
    public function it_should_subscribe_using_default_parameters()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString())
        );

        $this->assertEquals(new Value\UUID('1234'), $account->getAccountNumber());
        $this->assertEquals(Value\Money::fromFloat(50.00), $account->getRecurringCharge());
        $this->assertSame($dateOpened, $account->getDateOpened());
        $this->assertSame($dateOpened, $account->getBillingStartDate());
    }

    /**
     * @test
     */
    public function it_should_increase_recurring_charge()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString())
        );

        $account->increaseRecurringCharge(25.00);

        $this->assertEquals(Value\Money::fromFloat(75.00), $account->getRecurringCharge());
    }

    /**
     * @test
     */
    public function it_should_decrease_recurring_charge()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString())
        );

        $account->decreaseRecurringCharge(10.00);

        $this->assertEquals(Value\Money::fromFloat(40.00), $account->getRecurringCharge());
    }

    /**
     * @test
     */
    public function it_should_not_be_active_if_the_closing_date_is_today_or_earlier()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            null,
            $dateOpened
        );

        $this->assertFalse($account->isActive());


        $closingDate = $dateOpened->sub(new \DateInterval('P30D'));
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            null,
            $closingDate
        );

        $this->assertFalse($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_be_active_without_a_closing_date()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            null
        );

        $this->assertTrue($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_be_active_with_a_later_closing_date()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened->add(new \DateInterval('P3D')),
            $dateOpened->add(new \DateInterval('P5D'))
        );

        $this->assertTrue($account->isActive());

        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened->add(new \DateInterval('P3D'))
        );

        $account->scheduleAccountClosure(new \DateTime('now +7 days'));

        $this->assertTrue($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_be_closed_if_the_closing_date_is_earlier_than_today()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened->add(new \DateInterval('P3D')),
            $dateOpened->sub(new \DateInterval('P5D'))
        );

        $this->assertFalse($account->isActive());

        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened->add(new \DateInterval('P3D'))
        );

        $account->scheduleAccountClosure(new \DateTime('now -7 days'));

        $this->assertFalse($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_close_immediately_when_close_is_called()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened->add(new \DateInterval('P3D'))
        );

        $this->assertTrue($account->isActive());
        $account->close();
        $this->assertFalse($account->isActive());
    }

    /**
     * @test
     */
    public function it_should_provide_the_service_when_asked()
    {
        $service = $this->createServicesAndCompany();

        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $service,
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened->add(new \DateInterval('P3D'))
        );

        $this->assertSame($service, $account->getService());
    }

    /**
     * @test
     */
    public function it_should_return_a_date_interval_for_billing_interval()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString())
        );

        $interval = new \DateInterval((new Monthly)->getBillingIntervalString());

        $this->assertEquals($interval, $account->getBillingInterval());
        $this->assertNotEquals(new \DateInterval('P3M'), $account->getBillingInterval());
    }

    /**
     * @test
     */
    public function it_should_return_the_closure_date()
    {
        $dateOpened = new \DateTime('now');
        $dateClosed = new \DateTime('now +7 days');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString()),
            $dateOpened,
            $dateClosed
        );

        $this->assertEquals($dateClosed, $account->dateToClose());
    }

    /**
     * @test
     */
    public function it_should_have_a_default_closure_date_of_one_year_later()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString())
        );

        $this->assertEquals($dateOpened->add(new \DateInterval('P1Y')), $account->dateToClose());
    }

    /**
     * @test
     */
    public function it_should_convert_charge_from_float_to_int_and_back()
    {
        $dateOpened = new \DateTime('now');
        $account = Account::open(
            $this->createServicesAndCompany(),
            new Value\UUID('1234'),
            Value\Money::fromFloat(50.00),
            $dateOpened,
            new Value\BillingPeriod((new Monthly)->getBillingIntervalString())
        );

        $accountReflection = new \ReflectionClass($account);
        $chargeProperty = $accountReflection->getProperty('recurringCharge');
        $chargeProperty->setAccessible(true);

        $this->assertSame(5000, $chargeProperty->getValue($account));
        $this->assertEquals(Value\Money::fromFloat(50.00), $account->getRecurringCharge());
    }
}
 