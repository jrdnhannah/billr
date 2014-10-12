<?php

namespace HCLabs\Bills\Controller\API;

use HCLabs\Bills\Command\Bus\CommandBusInterface;
use HCLabs\Bills\Command\PayBillCommand;
use HCLabs\Bills\Exception\BillAlreadyPaidException;
use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Value\BillId;
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
     * @param  int $billId
     * @return JsonResponse
     */
    public function payAction($billId)
    {
        try {
            $command = new PayBillCommand(new BillId($billId));
            $this->commandBus->execute($command);

            return new JsonResponse(['bill' => $billId, 'has_been_paid' => true]);
        } catch (BillAlreadyPaidException $e) {
            throw new HttpException(409, $e->getMessage(), $e);
        }
    }
}