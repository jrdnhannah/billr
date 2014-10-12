<?php

namespace HCLabs\Bills\Tests\Model;


use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\UUID;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;
use HCLabs\Bills\Value\ProvidedService;

class BillTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_correctly()
    {
        $dateDue = new \DateTime('now +7 days');

        $account = $this->getAccount();

        $bill    = Bill::create($account, $dateDue);

        $billReflection = new \ReflectionClass($bill);
        $accountProperty = $billReflection->getProperty('account');
        $accountProperty->setAccessible(true);

        $amountProperty  = $billReflection->getProperty('amount');
        $amountProperty->setAccessible(true);

        $dateDueProperty = $billReflection->getProperty('dateDue');
        $dateDueProperty->setAccessible(true);

        $datePaidProperty = $billReflection->getProperty('datePaid');
        $datePaidProperty->setAccessible(true);

        $this->assertSame($account, $accountProperty->getValue($bill));
        $this->assertSame(5000, $amountProperty->getValue($bill));
        $this->assertSame($dateDue, $dateDueProperty->getValue($bill));
        $this->assertNull($datePaidProperty->getValue($bill));
    }

    /**
     * @test
     */
    public function it_should_store_the_date_paid()
    {
        $account = $this->getAccount();
        $bill = Bill::create($account, new \DateTime('now'));

        $billReflection = new \ReflectionClass($bill);
        $paidProperty = $billReflection->getProperty('datePaid');
        $paidProperty->setAccessible(true);
        $this->assertNull($paidProperty->getValue($bill));

        $bill->pay();

        $paidDate = $paidProperty->getValue($bill);

        $now = new \DateTime('now');

        // not going to be equal to the millisecond
        $this->assertInstanceOf('\DateTime', $paidDate);
        $this->assertEquals($now->format('d/m/Y h:i:s'), $paidDate->format('d/m/Y h:i:s'));
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_already_paid()
    {
        $this->setExpectedException('\HCLabs\Bills\Exception\BillAlreadyPaidException');
        $bill = Bill::create($this->getAccount(), new \DateTime('now'));

        $bill->pay();
        $bill->pay();
    }

    /**
     * @test
     */
    public function it_should_correctly_report_payment_status()
    {
        $bill = Bill::create($this->getAccount(), new \DateTime('now'));

        $this->assertSame(false, $bill->hasBeenPaid());
        $bill->pay();
        $this->assertSame(true, $bill->hasBeenPaid());
    }

    private function getAccount()
    {
        return Account::open(
            Service::fromName(new ProvidedService('foo')),
            new UUID('abc123'),
            Money::fromFloat(50.00),
            new \DateTime('now'),
            new BillingPeriod('P2Y')
        );
    }
}
 