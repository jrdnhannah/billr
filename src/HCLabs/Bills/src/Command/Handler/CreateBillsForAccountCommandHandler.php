<?php

namespace HCLabs\Bills\Command\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry;
use HCLabs\Bills\Model\Bill;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateBillsForAccountCommandHandler implements CommandHandler
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var Registry */
    private $doctrine;

    public function __construct(EventDispatcherInterface $dispatcher, Registry $doctrine)
    {
        $this->dispatcher = $dispatcher;
        $this->doctrine   = $doctrine;
    }

    /**
     * @param \HCLabs\Bills\Command\CreateBillsForAccountCommand $command
     */
    public function handle($command)
    {
        $manager        = $this->doctrine->getManagerForClass('HCLabs\Bills\Model\Bill');
        $account        = $command->account;
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