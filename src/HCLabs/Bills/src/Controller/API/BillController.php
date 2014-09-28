<?php

namespace HCLabs\Bills\Controller\API;

use HCLabs\Bills\Command\Bus\CommandBusInterface;
use HCLabs\Bills\Command\PayBillCommand;
use HCLabs\Bills\Exception\BillAlreadyPaidException;
use HCLabs\Bills\Model\Bill;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BillController
{
    /** @var CommandBusInterface */
    private $commandBus;

    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Bill $bill
     * @return JsonResponse
     */
    public function payAction(Bill $bill)
    {
        try {
            $command = new PayBillCommand($bill);
            $this->commandBus->execute($command);

            return new JsonResponse(['bill' => $bill->getId(), 'has_been_paid' => $bill->hasBeenPaid()]);
        } catch (BillAlreadyPaidException $e) {
            throw new HttpException(409, $e->getMessage(), $e);
        }
    }
}