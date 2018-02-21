<?php

namespace Konsulting\Exposer\Tests;

use Konsulting\Exposer\BaseExposer;
use Konsulting\Exposer\Tests\Stubs\ClassUnderTest;
use PHPUnit\Framework\TestCase;

class BaseExposerTest extends TestCase
{
    /** @test */
    public function it_checks_if_a_method_exists()
    {
        $this->assertTrue(BaseExposer::hasMethod(new ClassUnderTest, 'protectedMethod'));
        $this->assertFalse(BaseExposer::hasMethod(new ClassUnderTest, 'not_a_method'));
        $this->assertTrue(BaseExposer::hasMethod(ClassUnderTest::class, 'protectedStaticMethod'));
    }

    /** @test */
    public function it_checks_if_a_property_exists()
    {
        $this->assertTrue(BaseExposer::hasProperty(new ClassUnderTest, 'property'));
        $this->assertFalse(BaseExposer::hasProperty(new ClassUnderTest, 'not_a_property'));
        $this->assertTrue(BaseExposer::hasProperty(ClassUnderTest::class, 'staticProperty'));
    }

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
