<?php

namespace HCLabs\Bills\Tests\Model;


use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Service;

class BillTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_correctly()
    {
        $account = $this->getAccountMock();
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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAccountMock()
    {
        return $this->getMockBuilder('\HCLabs\Bills\Model\Account')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    private function getAccount()
    {
        return Account::open(Service::fromName('foo'), 'abc123', 50.00, new \DateTime('now'), 'P2Y');
    }
}
 