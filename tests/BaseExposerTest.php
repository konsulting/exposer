<?php

namespace Konsulting\Exposer\Tests;

use Konsulting\Exposer\BaseExposer;
use Konsulting\Exposer\Tests\Stubs\ClassUnderTest;
use PHPUnit\Framework\TestCase;

class BaseExposerTest extends TestCase
{
    /** @test */
    public function it_exposes_a_protected_method()
    {
        $this->assertEquals('arg1arg2',
            BaseExposer::invokeMethod(new ClassUnderTest, 'protectedMethod', ['arg1', 'arg2']));
    }

    /** @test */
    public function it_exposes_a_protected_static_method()
    {
        $this->assertEquals('arg1arg2',
            BaseExposer::invokeStaticMethod(new ClassUnderTest, 'protectedStaticMethod', ['arg1', 'arg2']));
    }

    /** @test */
    public function it_exposes_a_protected_property()
    {
        $this->assertEquals('I am protected', BaseExposer::getProperty(new ClassUnderTest, 'property'));
    }

    /** @test */
    public function it_exposes_a_protected_static_property()
    {
        $this->assertEquals('I am static protected',
            BaseExposer::getProperty(ClassUnderTest::class, 'staticProperty'));
    }
}
