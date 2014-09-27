<?php

namespace HCLabs\Bills\Tests\Command\Handler;


use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Command\CreateBillsForAccountCommand;
use HCLabs\Bills\Command\Handler\CreateBillsForAccountCommandHandler;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\AccountId;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;

class CreateBillsForAccountCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_a_bill_for_every_date_period()
    {
        $account = $this->getAccount();
        $registry = $this->getRegistryMock();
        $em = $this->getEntityManagerMock();
        $dispatcher = $this->getEventDispatcherMock();
        $command = new CreateBillsForAccountCommand($account);

        $registry->expects($this->once())
                 ->method('getManagerForClass')
                 ->willReturn($em);


        $em->expects($this->exactly(2))
            ->method('persist')
            ->with($this->callback(function($bill) {
                        return $bill instanceof Bill;
                    }
                )
            );

        $em->expects($this->once())
            ->method('flush');


        $handler = new CreateBillsForAccountCommandHandler($dispatcher, $registry);
        $handler->handle($command);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRegistryMock()
    {
        return $this->getMockBuilder('\Doctrine\Bundle\DoctrineBundle\Registry')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getEventDispatcherMock()
    {
        return $this->getMockBuilder('\Symfony\Component\EventDispatcher\EventDispatcherInterface')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return Account
     */
    private function getAccount()
    {
        $service = Service::fromName('FooBar');
        return Account::open(
            $service,
            new AccountId('abc123'),
            Money::fromFloat(50.00),
            new \DateTime('now'),
            new BillingPeriod((new Monthly())->getBillingIntervalString()),
            null,
            new \DateTime('now +2 months')
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getEntityManagerMock()
    {
        return $this->getMockBuilder('\Doctrine\ORM\EntityManagerInterface')
                    ->disableOriginalConstructor()
                    ->getMockForAbstractClass();
    }
}
 