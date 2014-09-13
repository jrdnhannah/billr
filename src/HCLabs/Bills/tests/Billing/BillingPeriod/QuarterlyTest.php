<?php
namespace HCLabs\Bills\Tests\Billing\BillingPeriod;

use HCLabs\Bills\Billing\BillingPeriod\Quarterly;

class QuarterlyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_an_interval_of_three_months()
    {
        $quarterly = new Quarterly;
        $period    = 'P3M';
        $interval  = new \DateInterval($period);

        $this->assertEquals($interval, $quarterly->getBillingInterval());
        $this->assertEquals($period, $quarterly->getBillingIntervalString());
    }
}
