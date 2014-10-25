<?php

namespace HCLabs\Bills\Command\Scenario\PayBill;

use HCLabs\Bills\Command\Handler\AbstractCommandHandler;
use HCLabs\Bills\Event\BillHasBeenPaidEvent;
use HCLabs\Bills\Model\Repository\BillRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PayBillCommandHandler extends AbstractCommandHandler
{
    /** @var BillRepository */
    private $billRepository;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param BillRepository $billRepository
     */
    public function __construct(EventDispatcherInterface $dispatcher, BillRepository $billRepository)
    {
        parent::__construct($dispatcher);
        $this->billRepository = $billRepository;
    }

    /**
     * @param \HCLabs\Bills\Command\Scenario\PayBill\PayBillCommand $command
     */
    public function handle($command)
    {
        $command->getBill()->pay();

        $this->billRepository->save($command->getBill());

        $this->dispatch('bill.paid', new BillHasBeenPaidEvent($command->getBill()));
    }

}