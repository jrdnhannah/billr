<?php

namespace HCLabs\Bills\Controller;

use HCLabs\Bills\Command\Bus\CommandBusInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccountController
{
    /** @var CommandBusInterface */
    private $commandBus;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var \Twig_Environment */
    private $templating;

    public function __construct(
        \Twig_Environment $templating,
        UrlGeneratorInterface $urlGenerator,
        CommandBusInterface $commandBus,
        FormFactoryInterface $formFactory
    ) {
        $this->templating = $templating;
        $this->urlGenerator = $urlGenerator;
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
    }

    /**
     * @return Response
     */
    public function openAction()
    {
        return $this->getFormResponse($this->createAccountForm());
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function processAccountCreationAction(Request $request)
    {
        $form = $this->createAccountForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->commandBus->execute($form->getData());

            return new RedirectResponse(
                $this->urlGenerator->generate('hclabs_bills.dashboard_controller.index')
            );
        }

        return $this->getFormResponse($form);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createAccountForm()
    {
        return $this->formFactory->create(
            'hclabs_bills_open_account_type',
            null,
            ['action' => $this->urlGenerator->generate('hclabs_bills.account_controller.process')]
        );
    }

    /**
     * @param  FormInterface $form
     * @return Response
     */
    private function getFormResponse(FormInterface $form)
    {
        return new Response(
            $this->templating->render(
                '@HCLabsBills/Account/open.html.twig',
                ['form' => $form->createView()]
            )
        );
    }
}