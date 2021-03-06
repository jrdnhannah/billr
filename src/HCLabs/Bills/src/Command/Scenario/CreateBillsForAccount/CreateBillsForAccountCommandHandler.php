<?php

namespace HCLabs\Bills\Command\Scenario\CreateBillsForAccount;

use HCLabs\Bills\Command\Handler\AbstractCommandHandler;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Model\Repository\BillRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateBillsForAccountCommandHandler extends AbstractCommandHandler
{
    /** @var BillRepository */
    private $billRepository;

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
     * @param CreateBillsForAccountCommand $command
     * @return void
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