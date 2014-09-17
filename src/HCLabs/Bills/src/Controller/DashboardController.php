<?php

namespace HCLabs\Bills\Controller;

use HCLabs\Bills\Model\Repository\AccountRepository;
use Symfony\Component\HttpFoundation\Response;

class DashboardController
{
    /** @var \Twig_Environment */
    private $templating;

    /** @var AccountRepository */
    private $accountRepository;

    /**
     * @param \Twig_Environment $templating
     * @param AccountRepository $accountRepository
     */
    public function __construct(\Twig_Environment $templating, AccountRepository $accountRepository)
    {
        $this->templating        = $templating;
        $this->accountRepository = $accountRepository;
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $accounts = $this->accountRepository->findAll();

        return new Response(
            $this->templating->render(
                '@HCLabsBills/Dashboard/index.html.twig',
                ['accounts' => $accounts]
            )
        );
    }
}