<?php

namespace HCLabs\Bills\Event\Subscriber;

use HCLabs\Bills\Command\Bus\CommandBusInterface;
use HCLabs\Bills\Command\Scenario\CreateBillsForAccount\CreateBillsForAccountCommand;
use HCLabs\Bills\Event\AccountWasOpenedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AccountWasOpenedSubscriber implements EventSubscriberInterface
{
    /** @var CommandBusInterface */
    private $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'account.opened' => [
                ['onAccountOpened', 255]
            ]
        ];
    }

    /**
     * @param AccountWasOpenedEvent $e
     */
    public function onAccountOpened(AccountWasOpenedEvent $e)
    {
        $command = new CreateBillsForAccountCommand($e->getAccount());

        $this->commandBus->execute($command);
    }
}