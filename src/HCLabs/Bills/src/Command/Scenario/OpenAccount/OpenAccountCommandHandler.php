<?php

namespace HCLabs\Bills\Command\Scenario\OpenAccount;

use HCLabs\Bills\Command\Handler\AbstractCommandHandler;
use HCLabs\Bills\Event\AccountWasOpenedEvent;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Model\Repository\AccountRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OpenAccountCommandHandler extends AbstractCommandHandler
{
    /** @var AccountRepository */
    private $accountRepository;

    /**
     * @param EventDispatcherInterface $dispatcher
     * @param AccountRepository $accountRepository
     */
    public function __construct(EventDispatcherInterface $dispatcher, AccountRepository $accountRepository)
    {
        parent::__construct($dispatcher);
        $this->accountRepository = $accountRepository;
    }

    /**
     * @param OpenAccountCommand $command
     * @return void
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

        $this->accountRepository->save($account);

        $this->dispatch('account.opened', new AccountWasOpenedEvent($account));
    }
}