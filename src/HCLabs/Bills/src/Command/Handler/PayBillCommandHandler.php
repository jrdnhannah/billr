<?php

namespace HCLabs\Bills\Command\Handler;

use Doctrine\ORM\EntityManagerInterface;
use HCLabs\Bills\Event\BillHasBeenPaidEvent;
use HCLabs\Bills\Model\Repository\BillRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PayBillCommandHandler extends AbstractCommandHandler
{
    /** @var BilLRepository */
    private $billRepository;

    public function __construct(EventDispatcherInterface $dispatcher, EntityManagerInterface $em, BillRepository $billRepository)
    {
        parent::__construct($dispatcher, $em);
        $this->billRepository = $billRepository;
    }

    /**
     * @param \HCLabs\Bills\Command\PayBillCommand $command
     */
    public function handle($command)
    {
        $command->getBill()->pay();

        $this->billRepository->save($command->getBill());

        $this->dispatch('bill.paid', new BillHasBeenPaidEvent($command->getBill()));
    }

}