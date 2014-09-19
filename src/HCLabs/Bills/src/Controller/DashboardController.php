<?php

namespace HCLabs\Bills\Controller;

use HCLabs\Bills\Model\Repository\AccountRepository;
use HCLabs\Bills\Model\Repository\BillRepository;
use Symfony\Component\HttpFoundation\Response;

class DashboardController
{
    /** @var \Twig_Environment */
    private $templating;

    /** @var AccountRepository */
    private $accountRepository;

    /** @var BillRepository */
    private $billRepository;

    /**
     * @param \Twig_Environment $templating
     * @param AccountRepository $accountRepository
     * @param BillRepository $billRepository
     */
    public function __construct(
        \Twig_Environment $templating,
        AccountRepository $accountRepository,
        BillRepository $billRepository
    ) {
        $this->templating        = $templating;
        $this->accountRepository = $accountRepository;
        $this->billRepository    = $billRepository;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $accounts = $this->accountRepository->findAll();
        $upcomingBills = $this->billRepository->findBillsDue(new \DateInterval('P1M'));

        return new Response(
            $this->templating->render(
                '@HCLabsBills/Dashboard/index.html.twig',
                ['accounts' => $accounts, 'upcoming_bills' => $upcomingBills]
            )
        );
    }
}