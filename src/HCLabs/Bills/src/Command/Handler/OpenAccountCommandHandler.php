<?php

namespace HCLabs\Bills\Command\Handler;

use Doctrine\Bundle\DoctrineBundle\Registry;
use HCLabs\Bills\Command\OpenAccountCommand;
use HCLabs\Bills\Event\AccountWasOpenedEvent;
use HCLabs\Bills\Model\Account;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OpenAccountCommandHandler implements CommandHandler
{
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /** @var Registry */
    private $registry;

    public function __construct(EventDispatcherInterface $dispatcher, Registry $registry)
    {
        $this->dispatcher = $dispatcher;
        $this->registry   = $registry;
    }

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

        $manager = $this->registry->getManagerForClass(get_class($account));
        $manager->persist($account);
        $manager->flush();

        $this->dispatcher->dispatch('account.opened', new AccountWasOpenedEvent($account));
    }
}