<?php

namespace HCLabs\Bills\Tests\Command\Scenario\OpenAccount;

use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Command\Scenario\OpenAccount\OpenAccountCommandHandler;
use HCLabs\Bills\Command\Scenario\OpenAccount\OpenAccountCommand;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Tests\Stub\Model\Repository\Doctrine\AccountRepository;
use HCLabs\Bills\Value\UUID;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;
use HCLabs\Bills\Value\ProvidedService;

class OpenAccountCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_persist_an_account_to_the_database()
    {
        $repository = new AccountRepository;
        $command = $this->configureOpenAccountCommand();

        $account = Account::open(
            $command->getService(),
            $command->getAccountNumber(),
            $command->getRecurringCharge(),
            $command->getDateOpened(),
            $command->getBillingPeriod()
        );

        $handler = new OpenAccountCommandHandler($this->getEventDispatcherMock(), $repository);
        $handler->handle($command);

        $this->assertSame(1, count($repository->findAll()));
        $this->assertEquals($account, $repository->findAll()[0]);
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
            Service::fromName(new ProvidedService('Hammers for Rental')),
            new UUID('abc123'),
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
 