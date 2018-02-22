<?php

namespace Konsulting\Exposer\Tests;

use Konsulting\Exposer\Exposer;
use Konsulting\Exposer\StaticExposer;
use Konsulting\Exposer\Tests\Stubs\ClassUnderTest;
use PHPUnit\Framework\TestCase;

class StaticExposerTest extends TestCase
{
    /**
     * @var Exposer
     */
    protected $exposer;

    protected function setUp()
    {
        parent::setUp();

        $this->exposer = Exposer::make(ClassUnderTest::class);
    }

    /** @test */
    public function it_exposes_a_protected_static_method()
    {
        $this->assertEquals('arg1arg2', $this->exposer->invokeMethod('protectedStaticMethod', ['arg1', 'arg2']));
        $this->assertEquals('arg1arg2', $this->exposer->protectedStaticMethod('arg1', 'arg2'));
    }

    /** @test */
    public function it_defers_to_parent_call_static_method()
    {
        $this->assertEquals('You called static: arg1', $this->exposer->invokeMethod('not_a_method', ['arg1']));
        $this->assertEquals('You called static: arg1', $this->exposer->notAMethod('arg1'));
    }

    /** @test */
    public function it_exposes_a_protected_property()
    {
        $this->assertEquals('I am static protected', $this->exposer->getProperty('staticProperty'));
    }
}
