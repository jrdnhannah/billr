<?php

namespace HCLabs\Bills\Tests\Value;

use HCLabs\Bills\Value as DTO;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_convert_floats_to_integer_internally()
    {
        $money = DTO\Money::fromFloat(12.99);
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
        $money = DTO\Money::fromFloat(12.99);

        $this->assertInternalType('int', $money->toInt());
        $this->assertSame(1299, $money->toInt());

        $this->assertInternalType('float', $money->toFloat());
        $this->assertSame(12.99, $money->toFloat());
    }

    /**
     * @test
     */
    public function it_should_only_accept_floats_and_integers()
    {
        $money1 = DTO\Money::fromFloat(12.99);
        $this->assertSame(12.99, $money1->toFloat());
        $this->assertSame(1299, $money1->toInt());

        $money2 = DTO\Money::fromInteger(1599);
        $this->assertSame(15.99, $money2->toFloat());
        $this->assertSame(1599, $money2->toInt());
    }

    /**
     * @test
     */
    public function it_should_provide_a_string()
    {
        $money = DTO\Money::fromFloat(12.99);

        $this->assertSame('12.99', (string) $money);
    }
}
 