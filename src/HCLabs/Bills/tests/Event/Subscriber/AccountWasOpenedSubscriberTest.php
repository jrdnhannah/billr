<?php

namespace HCLabs\Bills\Tests\Event\Subscriber;


use HCLabs\Bills\Command\CreateBillsForAccountCommand;
use HCLabs\Bills\Event\AccountWasOpenedEvent;
use HCLabs\Bills\Event\Subscriber\AccountWasOpenedSubscriber;

class AccountWasOpenedSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_add_a_command_to_the_command_bus()
    {
        $bus              = $this->getCommandBusMock();
        $subscriber       = new AccountWasOpenedSubscriber($bus);
        $account          = $this->getAccountMock();
        $event            = new AccountWasOpenedEvent($account);
        $command          = new CreateBillsForAccountCommand;
        $command->account = $account;

        $bus->expects($this->once())
            ->method('execute')
            ->with($command);

        $subscriber->onAccountOpened($event);
    }

    /**
     * @test
     */
    public function it_should_return_handled_events()
    {
        $events = [
            'account.opened' => [
                ['onAccountOpened', 255]
            ]
        ];

        $this->assertSame($events, AccountWasOpenedSubscriber::getSubscribedEvents());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getCommandBusMock()
    {
        return $this->getMockBuilder('\HCLabs\Bills\Command\Bus\CommandBusInterface')
                    ->disableOriginalConstructor()
                    ->getMockForAbstractClass();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getAccountMock()
    {
        return $this->getMockBuilder('HCLabs\Bills\Model\Account')
                    ->disableOriginalConstructor()
                    ->getMock();
    }
}
 