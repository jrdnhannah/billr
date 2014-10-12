<?php

namespace HCLabs\Bills\Command\Handler;

use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Repository\BillRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateBillsForAccountCommandHandler extends AbstractCommandHandler
{
    /**
     * @param EventDispatcherInterface $dispatcher
     * @param BillRepository           $billRepository
     */
    public function __construct(EventDispatcherInterface $dispatcher, BillRepository $billRepository)
    {
        parent::__construct($dispatcher);
        $this->billRepository = $billRepository;
    }

    /**
     * @param \HCLabs\Bills\Command\CreateBillsForAccountCommand $command
     */
    public function handle($command)
    {
        $account        = $command->getAccount();
        $billingPeriod  = new \DatePeriod($account->getBillingStartDate(),
                                          $account->getBillingInterval(),
                                          $account->dateToClose());

        foreach ($billingPeriod as $billDate) {
            $bill = Bill::create($account, $billDate);
            $this->billRepository->save($bill);
        }
    }
}