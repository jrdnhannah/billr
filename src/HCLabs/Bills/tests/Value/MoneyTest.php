<?php

namespace HCLabs\Bills\Tests\Value;

use HCLabs\Bills\Value as DTO;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_convert_amount_to_integer_internally()
    {
        $money = new DTO\Money(12.99);
        $reflection = new \ReflectionClass($money);
        $amount = $reflection->getProperty('amount');
        $amount->setAccessible(true);

        $this->assertSame(1299, $amount->getValue($money));
        $this->assertInternalType('int', $amount->getValue($money));
    }

    /**
     * @test
     */
    public function it_should_produce_integer_and_double_amounts()
    {
        $money = new DTO\Money(12.99);

        $this->assertInternalType('int', $money->toInt());
        $this->assertSame(1299, $money->toInt());

        $this->assertInternalType('float', $money->toFloat());
        $this->assertSame(12.99, $money->toFloat());
    }

    /**
     * @test
     */
    public function it_should_only_accept_floats()
    {
        $this->setExpectedException('\Assert\InvalidArgumentException');

        new DTO\Money(1234);
    }
}
 