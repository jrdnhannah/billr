<?php

namespace HCLabs\Bills\Command\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry;
use HCLabs\Bills\Model\Bill;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateBillsForAccountCommandHandler extends AbstractCommandHandler
{
    /**
     * @param \HCLabs\Bills\Command\CreateBillsForAccountCommand $command
     */
    public function handle($command)
    {
        $manager        = $this->getEntityManager();
        $account        = $command->getAccount();
        $billingPeriod  = new \DatePeriod($account->getBillingStartDate(),
                                          $account->getBillingInterval(),
                                          $account->dateToClose());

        foreach ($billingPeriod as $billDate) {
            $bill = Bill::create($account, $billDate);
            $manager->persist($bill);
        }

        $manager->flush();
    }
}