<?php

namespace HCLabs\Bills\Tests\Command\Scenario\PayBill;

use HCLabs\Bills\Command\Scenario\PayBill\PayBillCommand;
use HCLabs\Bills\Command\Scenario\PayBill\PayBillCommandHandler;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Tests\Stub\Model\Repository\Doctrine\BillRepository;
use HCLabs\Bills\Value\Money;

class PayBillCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_pay_a_bill()
    {
        $dispatcher = $this->getMockForAbstractClass('\Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $account    = $this->getMockBuilder('\HCLabs\Bills\Model\Account')->disableOriginalConstructor()->getMock();
        $charge     = Money::fromInteger(2000);

        $account->expects($this->once())
                ->method('getRecurringCharge')
                ->willReturn($charge);

        $billRepository = new BillRepository;

        $commandHandler = new PayBillCommandHandler($dispatcher, $billRepository);


        $bill = Bill::create(
            $account,
            new \DateTime('tomorrow')
        );

        $command = new PayBillCommand($bill);

        $this->assertFalse($bill->hasBeenPaid());

        $commandHandler->handle($command);

        $this->assertTrue($bill->hasBeenPaid());
    }
}
 