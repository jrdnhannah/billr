<?php

namespace HCLabs\Bills\Tests\Command\Handler;


use HCLabs\Bills\Command\CreateBillsForAccountCommand;
use HCLabs\Bills\Command\Handler\CreateBillsForAccountCommandHandler;
use HCLabs\Bills\Model\Bill;

class CreateBillsForAccountCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_a_bill_for_every_date_period()
    {
        $account = $this->getAccountMock();
        $registry = $this->getRegistryMock();
        $em = $this->getEntityManagerMock();
        $dispatcher = $this->getEventDispatcherMock();
        $command = new CreateBillsForAccountCommand;
        $command->account = $account;

        $registry->expects($this->once())
                 ->method('getManagerForClass')
                 ->willReturn($em);

        $account->expects($this->once())
                ->method('getBillingStartDate')
                ->willReturn(new \DateTime('now'));

        $account->expects($this->once())
                ->method('getBillingInterval')
                ->willReturn(new \DateInterval('P1M'));

        $account->expects($this->once())
                ->method('dateToClose')
                ->willReturn(new \DateTime('now +2 months'));

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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAccountMock()
    {
        return $this->getMockBuilder('\HCLabs\Bills\Model\Account')
                    ->disableOriginalConstructor()
                    ->getMock();
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
 