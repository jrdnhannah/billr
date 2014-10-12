<?php

namespace HCLabs\Bills\Tests\Command\Scenario\CreateBills;


use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Command\Scenario\CreateBillsForAccount\CreateBillsForAccountCommand;
use HCLabs\Bills\Command\Scenario\CreateBillsForAccount\CreateBillsForAccountCommandHandler;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Tests\Stub\Model\Repository\Doctrine\BillRepository;
use HCLabs\Bills\Value\UUID;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;
use HCLabs\Bills\Value\ProvidedService;

class CreateBillsForAccountCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_a_bill_for_every_date_period()
    {
        $account = $this->getAccount();
        $dispatcher = $this->getEventDispatcherMock();
        $command = new CreateBillsForAccountCommand($account);
        $repository = new BillRepository;

        $handler = new CreateBillsForAccountCommandHandler($dispatcher, $repository);
        $handler->handle($command);

        $this->assertSame(2, count($repository->findAll()));
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
        $service = Service::fromName(new ProvidedService('FooBar'));
        return Account::open(
            $service,
            new UUID('abc123'),
            Money::fromFloat(50.00),
            new \DateTime('now'),
            new BillingPeriod((new Monthly())->getBillingIntervalString()),
            null,
            new \DateTime('now +2 months')
        );
    }
}
 