<?php

namespace HCLabs\Bills\Tests\Command\Handler;

use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Command\Handler\OpenAccountCommandHandler;
use HCLabs\Bills\Command\OpenAccountCommand;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;

class OpenAccountCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_persist_an_account_to_the_database()
    {
        $entityManager = $this->getMockBuilder('\Doctrine\ORM\EntityManager')
                              ->disableOriginalConstructor()
                              ->getMock();

        $registry      = $this->getFullRegistryMock($entityManager);

        $command = $this->configureOpenAccountCommand();

        $account = Account::open(
            $command->getService(),
            $command->getAccountNumber(),
            $command->getRecurringCharge(),
            $command->getDateOpened(),
            $command->getBillingPeriod()
        );

        $entityManager->expects($this->once())
                        ->method('persist')
                        ->with($account);
        $entityManager->expects($this->once())
                        ->method('flush');

        $handler = new OpenAccountCommandHandler($this->getEventDispatcherMock(), $registry);
        $handler->handle($command);
    }

    /**
     * @param $entityManagerMock
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getFullRegistryMock($entityManagerMock)
    {
        $registry = $this->getRegistryMock();

        $registry->expects($this->once())
                ->method('getManagerForClass')
                ->with($this->callback(function($s) { return is_string($s); }))
                ->willReturn($entityManagerMock);

        return $registry;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getEventDispatcherMock()
    {
        $dispatcher = $this->getMockForAbstractClass('\Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $dispatcher->expects($this->any())
                   ->method('dispatch');

        return $dispatcher;
    }

    /**
     * @return OpenAccountCommand
     */
    private function configureOpenAccountCommand()
    {
        return new OpenAccountCommand(
            Service::fromName('Hammers for Rental'),
            'abc123',
            Money::fromFloat(25.00),
            new \DateTime('now'),
            new BillingPeriod((new Monthly)->getBillingIntervalString())
        );
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
}
 