<?php

namespace Konsulting\Exposer\Tests;

use Konsulting\Exposer\StaticExposer;
use Konsulting\Exposer\Tests\Stubs\ClassUnderTest;
use PHPUnit\Framework\TestCase;

class StaticExposerTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        StaticExposer::setClass(ClassUnderTest::class);
    }

    /** @test */
    public function it_exposes_a_protected_static_method()
    {
        $this->assertEquals('arg1arg2', StaticExposer::invokeMethod('protectedStaticMethod', ['arg1', 'arg2']));
        $this->assertEquals('arg1arg2', StaticExposer::protectedStaticMethod('arg1', 'arg2'));
    }

    /** @test */
    public function it_defers_to_parent_call_static_method()
    {
        $this->assertEquals('You called static: arg1', StaticExposer::invokeMethod('not_a_method', ['arg1']));
        $this->assertEquals('You called static: arg1', StaticExposer::notAMethod('arg1'));
    }

    /** @test */
    public function it_exposes_a_protected_property()
    {
        $this->assertEquals('I am static protected', StaticExposer::getProperty('staticProperty'));
    }
}
