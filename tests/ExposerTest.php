<?php

namespace Konsulting\Exposer\Tests;

use Konsulting\Exposer\Tests\Stubs\ExposingClass;
use PHPUnit\Framework\TestCase;

class ExposerTest extends TestCase
{
    /** @test */
    public function it_exposes_a_protected_method()
    {
        $this->assertEquals('arg1arg2', (new ExposingClass)->_expose_protectedMethod('arg1', 'arg2'));
    }

    /** @test */
    public function it_exposes_a_protected_static_method()
    {
        $this->assertEquals('arg1arg2', (new ExposingClass)::_expose_protectedStaticMethod('arg1', 'arg2'));
    }

    /** @test */
    public function it_exposes_a_protected_property()
    {
        $this->assertEquals('I am protected', (new ExposingClass)->_expose_property);
    }

    /** @test */
    public function it_defers_to_parent_call_method()
    {
        $this->assertEquals('You called: arg1', (new ExposingClass)->notAMethod('arg1'));
    }

    /** @test */
    public function it_defers_to_parent_call_static_method()
    {
        $this->assertEquals('You called static: arg1', (new ExposingClass)::notAMethod('arg1'));
    }
}
