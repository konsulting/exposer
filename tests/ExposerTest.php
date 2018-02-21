<?php

namespace Konsulting\Exposer\Tests;

use Konsulting\Exposer\Exposer;
use Konsulting\Exposer\Tests\Stubs\ClassUnderTest;
use PHPUnit\Framework\TestCase;

class ExposerTest extends TestCase
{
    /**
     * @var Exposer
     */
    protected $exposer;

    protected function setUp()
    {
        parent::setUp();

        $this->exposer = Exposer::make(new ClassUnderTest);
    }

    /** @test */
    public function it_exposes_a_protected_method()
    {
        $this->assertEquals('arg1arg2', $this->exposer->protectedMethod('arg1', 'arg2'));
    }

    /** @test */
    public function it_exposes_a_protected_static_method_if_called_non_statically()
    {
        $this->assertEquals('arg1arg2', $this->exposer->protectedStaticMethod('arg1', 'arg2'));
    }

    /** @test */
    public function it_exposes_a_protected_property()
    {
        $this->assertEquals('I am protected', $this->exposer->property);
    }

    /** @test */
    public function it_defers_to_parent_call_method()
    {
        $this->assertEquals('You called: arg1', $this->exposer->notAMethod('arg1'));
    }

    /** @test */
    public function it_defers_to_parent_get_method()
    {
        $this->assertEquals('You tried to get: notAProperty', $this->exposer->notAProperty);
    }
}
