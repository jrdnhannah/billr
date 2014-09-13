<?php
namespace HCLabs\Bills\Tests\Billing\BillingPeriod;

use HCLabs\Bills\Billing\BillingPeriod\Monthly;

class MonthlyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_return_an_inteval_of_one_month()
    {
        $monthly  = new Monthly;
        $period   = 'P1M';
        $interval = new \DateInterval($period);

        $this->assertEquals($interval, $monthly->getBillingInterval());
        $this->assertEquals($period, $monthly->getBillingIntervalString());
    }
}
 