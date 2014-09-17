<?php
namespace HCLabs\Bills\Tests\Controller;

use HCLabs\Bills\Controller\DashboardController;

class DashboardControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_the_dashboard_view_with_accounts()
    {
        $templating = $this->getTemplatingMock();
        $templating->expects($this->once())
                    ->method('render')
                    ->with('@HCLabsBills/Dashboard/index.html.twig', ['accounts' => []]);

        $repository = $this->getRepositoryMock();
        $repository->expects($this->once())
                   ->method('findAll')
                   ->willReturn([]);

        $controller = new DashboardController($templating, $repository);
        $response   = $controller->indexAction();

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getTemplatingMock()
    {
        return $this->getMock('\Twig_Environment');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getRepositoryMock()
    {
        return $this->getMockForAbstractClass('\HCLabs\Bills\Model\Repository\AccountRepository');
    }
}
 