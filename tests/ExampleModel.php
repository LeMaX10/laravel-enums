<?php


namespace LeMaX10\Enums\Tests;


use Illuminate\Database\Eloquent\Model;
use LeMaX10\Enums\Traits\ModelEnums;

class ExampleModel extends Model
{
    use ModelEnums;

    protected $enums = [
        'foo' => FooEnum::class
    ];
}