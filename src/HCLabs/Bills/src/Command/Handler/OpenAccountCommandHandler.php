<?php

namespace HCLabs\Bills\Command\Handler;

use HCLabs\Bills\Command\OpenAccountCommand;
use HCLabs\Bills\Event\AccountWasOpenedEvent;
use HCLabs\Bills\Model\Account;

class OpenAccountCommandHandler extends AbstractCommandHandler
{
    /**
     * @param OpenAccountCommand $command
     */
    public function handle($command)
    {
        $account = Account::open(
            $command->getService(),
            $command->getAccountNumber(),
            $command->getRecurringCharge(),
            $command->getDateOpened(),
            $command->getBillingPeriod()
        );

        $manager = $this->getEntityManager();
        $manager->persist($account);
        $manager->flush();

        $this->dispatch('account.opened', new AccountWasOpenedEvent($account));
    }
}