<?php

namespace HCLabs\Bills\Command\Handler;

use HCLabs\Bills\Event\BillHasBeenPaidEvent;

class PayBillCommandHandler extends AbstractCommandHandler
{
    /**
     * @param \HCLabs\Bills\Command\PayBillCommand $command
     */
    public function handle($command)
    {
        $command->getBill()->pay();

        $this->getEntityManager()->flush();

        $this->dispatch('bill.paid', new BillHasBeenPaidEvent($command->getBill()));
    }

}