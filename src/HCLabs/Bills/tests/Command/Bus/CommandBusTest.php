<?php
namespace HCLabs\Bills\Tests\Command\Bus;

use HCLabs\Bills\Command\Bus\CommandBus;
use HCLabs\Bills\Tests\Stub\Command\Handler\CommandHandler_stub;

class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_add_a_handler()
    {
        $commandBus = new CommandBus;
        $handler = new CommandHandler_stub;

        $reflection = new \ReflectionProperty($commandBus, 'handlers');
        $reflection->setAccessible(true);
        $this->assertSame([], $reflection->getValue($commandBus));

        $commandBus->addHandler($handler);

        $this->assertSame([$handler], $reflection->getValue($commandBus));
    }

    /**
     * @test
     */
    public function it_should_handle_execute_a_correct_handler()
    {
        $commandBus = new CommandBus;
        $handler = new CommandHandler_stub;

        $commandBus->addHandler($handler);

        $this->assertFalse($handler->handled);

        $commandBus->execute('foo');

        $this->assertTrue($handler->handled);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_on_no_handler()
    {
        $this->setExpectedException('HCLabs\Bills\Exception\NoCommandHandlerFoundException');
        $commandBus = new CommandBus;
        $commandBus->execute('foo');
    }

    /**
     * @test
     */
    public function it_show_throw_exception_on_no_supported_handler()
    {
        $this->setExpectedException('HCLabs\Bills\Exception\NoCommandHandlerFoundException');
        $commandBus = new CommandBus;
        $commandBus->addHandler(new CommandHandler_stub);

        $commandBus->execute('bar');
    }

    /**
     * @test
     */
    public function it_should_load_and_execute_command_handlers_in_a_specific_order()
    {
        $commandBus = new CommandBus;
        $handlerA   = new CommandHandler_stub(255);
        $handlerB   = new CommandHandler_stub(-20);
        $handlerC   = new CommandHandler_stub(0);
        $handlerD   = new CommandHandler_stub(0);

        $commandBus->addHandler($handlerA);
        $commandBus->addHandler($handlerB);
        $commandBus->addHandler($handlerC);
        $commandBus->addHandler($handlerD);

        $handlers = $commandBus->getHandlers();

        $expectedHandlers = [
            $handlerA,
            $handlerC,
            $handlerD,
            $handlerB
        ];

        $this->assertSame($expectedHandlers, $handlers);
    }
}
 