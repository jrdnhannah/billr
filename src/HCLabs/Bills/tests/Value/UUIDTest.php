<?php

namespace HCLabs\Bills\Tests\Value;

use HCLabs\Bills\Value as DTO;

class UUIDTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_accept_strings()
    {
        new DTO\UUID('abc123');
    }

    /**
     * @test
     */
    public function it_should_provide_a_string_representation()
    {
        $accountId = new DTO\UUID('abc123');

        $this->assertSame('abc123', (string) $accountId);
    }
}
 