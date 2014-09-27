<?php

namespace HCLabs\Bills\Tests\Value;

use HCLabs\Bills\Value as DTO;

class BillingPeriodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_only_accept_valid_date_interval_specs()
    {
        $this->setExpectedException('\HCLabs\Bills\Exception\InvalidDateIntervalSpecException');
        new DTO\BillingPeriod('foo');
    }

    /**
     * @test
     */
    public function it_should_provide_a_string_representation()
    {
        $billingPeriod = new DTO\BillingPeriod('P1D');

        $this->assertSame('P1D', (string) $billingPeriod);
    }

    /**
     * @test
     */
    public function it_should_provide_a_dateinterval_representation()
    {
        $billingPeriod = new DTO\BillingPeriod('P1D');

        $this->assertEquals(new \DateInterval('P1D'), $billingPeriod->toDateInterval());
    }
}
 