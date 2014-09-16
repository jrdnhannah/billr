<?php

namespace HCLabs\Bills\Tests\Command\Handler;

use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Command\Handler\OpenAccountCommandHandler;
use HCLabs\Bills\Command\OpenAccountCommand;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Service;

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
            $command->service,
            $command->accountNumber,
            $command->recurringCharge,
            $command->dateOpened,
            $command->billingPeriod
        );

        $entityManager->expects($this->once())
                        ->method('persist')
                        ->with($account);
        $entityManager->expects($this->once())
                        ->method('flush');

        $handler = new OpenAccountCommandHandler($registry);
        $handler->handle($command);
    }

    /**
     * @test
     */
    public function it_should_support_openaccountcommand_object()
    {
        $registry = $this->getRegistryMock();

        $handler = new OpenAccountCommandHandler($registry);

        $this->assertSame(get_class(new OpenAccountCommand), $handler->supports());
        $this->assertNotSame('Foo', $handler->supports());
    }

    /**
     * @test
     */
    public function it_should_have_a_priority_of_zero()
    {
        $registry = $this->getRegistryMock();
        $handler  = new OpenAccountCommandHandler($registry);

        $this->assertSame(0, $handler->getPriority());
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
     * @return OpenAccountCommand
     */
    private function configureOpenAccountCommand()
    {
        $command = new OpenAccountCommand;
        $command->billingPeriod = (new Monthly)->getBillingIntervalString();
        $command->service = Service::fromName('Hammers for Rental');
        $command->accountNumber = 'abc123';
        $command->dateOpened = new \DateTime('now');
        $command->recurringCharge = 25.00;

        return $command;
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
 