<?php

namespace LeMaX10\Enums\Tests;

use Illuminate\Validation\Validator;
use LeMaX10\Enums\Rules\EnumValue;
use PHPUnit\Framework\TestCase;

/**
 * Class EnumTest
 * @package LeMaX10\Enums\Tests
 */
class EnumTest extends TestCase
{
    /**
     * testing value
     */
    public function testEnumValues()
    {
        $this->assertEquals(FooEnum::ONE()->getValue(), 'one');
    }

    /**
     * testing setter model
     */
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

    /**
     * Testing validation rule
     */
    public function testValidation()
    {
        $validator = new EnumValue(FooEnum::class);
        $this->assertTrue($validator->passes('enum', FooEnum::ONE()->getValue()));
        $this->assertFalse($validator->passes('enum', 'test'));

        $validator = FooEnum::rule();
        $this->assertTrue($validator->passes('enum', FooEnum::ONE()->getValue()));
        $this->assertFalse($validator->passes('enum', 'test'));
    }
}