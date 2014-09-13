<?php

namespace HCLabs\Bills\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Response;

class DashboardController
{
    /** @var \Twig_Environment */
    private $templating;

    /** @var ObjectRepository */
    private $accountRepository;

    /**
     * @param \Twig_Environment $templating
     * @param ObjectRepository $accountRepository
     */
    public function __construct(\Twig_Environment $templating, ObjectRepository $accountRepository)
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