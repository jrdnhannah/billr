<?php

namespace HCLabs\Bills\Tests\Controller\API;

use HCLabs\Bills\Command\Bus\CommandBus;
use HCLabs\Bills\Command\Handler\PayBillCommandHandler;
use HCLabs\Bills\Command\PayBillCommand;
use HCLabs\Bills\Controller\API\BillController;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\UUID;
use HCLabs\Bills\Value\Money;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\ProvidedService;

class BillControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_a_payment_command()
    {
        $commandBus = $this->getMockForAbstractClass('\HCLabs\Bills\Command\Bus\CommandBusInterface');
        $controller = new BillController($commandBus);
        $bill       = $this->getBill();

        $command    = new PayBillCommand($bill);

        $commandBus->expects($this->once())
                   ->method('execute')
                   ->with($command);

        $controller->payAction($bill);
    }

    /**
     * @test
     */
    public function it_should_handle_bill_already_paid_exception_and_throw_an_http_exception()
    {
        $this->setExpectedException('\Symfony\Component\HttpKernel\Exception\HttpException');
        $dispatcherMock = $this->getMockForAbstractClass('\Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $emMock         = $this->getMockBuilder('\Doctrine\ORM\EntityManagerInterface')
                                ->disableOriginalConstructor()
                                ->getMock();

        $commandBus = new CommandBus;
        $handler    = new PayBillCommandHandler($dispatcherMock, $emMock);
        $commandBus->addHandler($handler, 'HCLabs\Bills\Command\PayBillCommand');
        $controller = new BillController($commandBus);
        $bill = $this->getBill();
        $bill->pay();

        $controller->payAction($bill);
    }

    /**
     * @return Bill
     */
    public function getBill()
    {
        $service = Service::fromName(new ProvidedService('foo'));
        $account = Account::open(
            $service,
            new UUID('abc123'),
            Money::fromFloat(20.00),
            new \DateTime('now'),
            new BillingPeriod('P30D')
        );

        $bill    = Bill::create($account, new \DateTime('now'));
        
        $this->injectId($bill);

        return $bill;
    }

    /**
     * @param $bill
     */
    private function injectId($bill)
    {
        $billReflection = new \ReflectionObject($bill);
        $id = $billReflection->getProperty('id');
        $id->setAccessible(true);
        $id->setValue($bill, 'abc123');
    }
}
 