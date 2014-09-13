<?php
namespace HCLabs\Bills\Tests\Controller;

use HCLabs\Bills\Controller\AccountController;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\HttpFoundation\Request;

class AccountControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var AccountController */
    private $sut;

    /** @var MockObject */
    private $templating;

    /** @var MockObject */
    private $url;

    /** @var MockObject */
    private $commandBus;

    /** @var MockObject */
    private $form;

    protected function setUp()
    {
        $this->templating = $this->getMock('\Twig_Environment');
        $this->url        = $this->getMockForAbstractClass('\Symfony\Component\Routing\Generator\UrlGeneratorInterface');
        $this->commandBus = $this->getMockForAbstractClass('\HCLabs\Bills\Command\Bus\CommandBusInterface');
        $this->form       = $this->getMockForAbstractClass('\Symfony\Component\Form\FormFactoryInterface');

        $this->sut        = new AccountController(
            $this->templating,
            $this->url,
            $this->commandBus,
            $this->form
        );
    }

    /**
     * @test
     */
    public function it_should_display_a_form_to_open_an_account()
    {
        $this->makeUrlGenerateOpenAccountRoute();
        $form = $this->getOpenAccountForm();

        $form->expects($this->once())
            ->method('createView');

        $this->makeFormFactoryReturnForm($form);

        $response = $this->sut->openAction();

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
    }

    /**
     * @test
     */
    public function it_should_display_a_form_when_submitted_form_is_invalid()
    {
        $this->makeUrlGenerateOpenAccountRoute();
        $form = $this->getOpenAccountForm();
        $this->makeFormFactoryReturnForm($form);
        $request = new Request;

        $this->makeFormHandleRequest($form, $request);

        $form->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $form->expects($this->once())
            ->method('createView');

        $this->templating->expects($this->once())
                        ->method('render');

        $response = $this->sut->processAccountCreationAction($request);

        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $response);
    }

    /**
     * @test
     */
    public function it_should_send_the_form_data_to_the_command_bus_when_form_is_valid()
    {
        $this->url->expects($this->exactly(2))
                  ->method('generate')
                  ->willReturn('/account/open');

        $form = $this->getOpenAccountForm();
        $this->makeFormFactoryReturnForm($form);
        $request = new Request;

        $this->makeFormHandleRequest($form, $request);

        $form->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $form->expects($this->once())
            ->method('getData')
            ->willReturn('FORM DATA');

        $this->commandBus->expects($this->once())
                        ->method('execute')
                        ->with('FORM DATA');

        $response = $this->sut->processAccountCreationAction($request);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\RedirectResponse', $response);
    }

    private function makeUrlGenerateOpenAccountRoute()
    {
        $this->url->expects($this->once())
            ->method('generate')
            ->willReturn('/account/open');
    }

    /**
     * @return MockObject
     */
    private function getOpenAccountForm()
    {
        $form = $this->getMockForAbstractClass('\Symfony\Component\Form\FormInterface');
        return $form;
    }

    /**
     * @param MockObject $form
     */
    private function makeFormFactoryReturnForm(MockObject $form)
    {
        $this->form->expects($this->once())
            ->method('create')
            ->with(
                'hclabs_bills_open_account_type',
                null,
                ['action' => '/account/open']
            )
            ->willReturn($form);
    }

    /**
     * @param MockObject $form
     * @param Request    $request
     */
    private function makeFormHandleRequest(MockObject $form, Request $request)
    {
        $form->expects($this->once())
            ->method('handleRequest')
            ->with($request);
    }
}
 