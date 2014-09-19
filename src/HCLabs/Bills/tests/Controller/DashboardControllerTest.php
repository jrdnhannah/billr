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
                    ->with('@HCLabsBills/Dashboard/index.html.twig', ['accounts' => [], 'upcoming_bills' => []]);

        $accountRepository = $this->getRepositoryMock();
        $accountRepository->expects($this->once())
                   ->method('findAll')
                   ->willReturn([]);

        $billRepository = $this->getBillRepositoryMock();
        $billRepository->expects($this->once())
                    ->method('findBillsDue')
                    ->with(new \DateInterval('P1M'))
                    ->willReturn([]);

        $controller = new DashboardController($templating, $accountRepository, $billRepository);
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getBillRepositoryMock()
    {
        return $this->getMockForAbstractClass('\HCLabs\Bills\Model\Repository\BillRepository');
    }
}
 