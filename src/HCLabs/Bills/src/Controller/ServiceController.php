<?php

namespace HCLabs\Bills\Controller;

use HCLabs\Bills\Model\Service;
use Symfony\Component\HttpFoundation\Response;

class ServiceController
{
    /** @var \Twig_Environment */
    private $templating;

    public function __construct(\Twig_Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @param  Service $service
     * @return Response
     */
    public function viewServiceAction(Service $service)
    {
        return new Response(
            $this->templating->render(
                '@HCLabsBills/Service/view.html.twig',
                ['service' => $service]
            )
        );
    }
}