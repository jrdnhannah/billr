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
}
 