<?php

namespace HCLabs\Bills\Tests\Controller;

use HCLabs\Bills\Controller\ServiceController;
use HCLabs\Bills\Model\Service;

class ServiceControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_view_service()
    {
        $service = Service::fromName('Hammer Rentals');

        $templating = $this->getTemplatingMock();
        $templating->expects($this->once())
                    ->method('render')
                    ->with('@HCLabsBills/Service/view.html.twig', ['service' => $service]);

        $controller = new ServiceController($templating);
        $response   = $controller->viewServiceAction($service);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
    }

    private function getTemplatingMock()
    {
        return $this->getMock('\Twig_Environment');
    }
}
 