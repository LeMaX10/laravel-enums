<?php

namespace LeMaX10\Enums\Tests;

use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{
    public function testEnumValues()
    {
        $this->assertEquals(FooEnum::ONE()->getValue(), 'one');
    }

    public function testSetModel()
    {
        $model = new ExampleModel;
        $model->foo = FooEnum::ONE();

        $this->assertEquals($model->foo, FooEnum::ONE());

        $model->foo = FooEnum::ONE()->getValue();
        $this->assertEquals($model->foo, FooEnum::ONE());
        $this->assertNotEquals($model->top, FooEnum::TWO());
        $this->assertInstanceOf(FooEnum::class, $model->foo);

        $this->expectException(\InvalidArgumentException::class);
        $model->foo = 1;
    }
}