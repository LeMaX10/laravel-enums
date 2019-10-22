**THIS PACKAGE IS STILL IN DEVELOPMENT, DO NOT USE YET**

# Laravel Enums

The package is based on the implementation of Enum from [myclabs/php-enum](https://github.com/myclabs/php-enum).

ExampleModel
```php
use App\Enums\ExampleStatusEnum;
use Illuminate\Database\Eloquent\Model;
use LeMaX10\Enums\Traits\ModelEnums;

/**
 * Class ExampleModel
 * @package App
 */
class ExampleModel extends Model
{
    use ModelEnums;

    /**
     * @var array
     */
    protected $enums = [
        'status' => ExampleStatusEnum::class
    ];
}
```

ExampleStatusEnum
```php
use LeMaX10\Enums\Enum;

/**
 * Class ExampleStatusEnum
 * @package App\Enums
 */
final class ExampleStatusEnum extends Enum
{
    /**
     *
     */
    private const FOO = 'foo';

    /**
     *
     */
    private const BAR = 'bar';
}
```

ExampleTranslatableEnum
```php
use LeMaX10\Enums\Enum;
use LeMaX10\Enums\Contracts\Translatable;

/**
 * Class ExampleStatusEnum
 * @package App\Enums
 */
final class ExampleStatusEnum extends Enum implements Translatable
{
    /**
     *
     */
    private const FOO = 'foo';

    /**
     *
     */
    private const BAR = 'bar';
    
    /**
     * Translatable value
     * @return string
     */
    public function getTransValue(): string
    {
        return trans('enum'. $this->value);
    }
}
```

Request Validation Rules
```php
<?php


namespace App\Http\Requests;


use App\Enums\ExampleStatusEnum;
use Illuminate\Http\Request;

class ExampleRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => 'required|enum:'. ExampleStatusEnum::class
        ];
    }
}
```

or
```php
<?php


namespace App\Http\Requests;


use App\Enums\ExampleStatusEnum;
use LeMaX10\Enums\Rules\EnumValue;
use Illuminate\Http\Request;

class ExampleRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => ['required', new EnumValue(ExampleStatusEnum::class)]
        ];
    }
}
```

or
```php
<?php


namespace App\Http\Requests;


use App\Enums\ExampleStatusEnum;
use Illuminate\Http\Request;

class ExampleRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => ['required', ExampleStatusEnum::rule()]
        ];
    }
}
```


## Installation

You can install the package via composer:

```bash
composer require LeMaX10/laravel-enums
```

Register the service provider in config/app.php from Laravel < 5.5:

```php
'providers' => [
    ...
    \LeMaX10\Enums\EnumServiceProvider::class,
    ...
]
```
## Usage

``` php
$exampleModel = new ExampleModel;
$exampleModel->status = ExampleStatusEnum::FOO();
$exampleModel->save();
....


echo $exampleModel->status
```

## Documentation

See documentation [myclabs/php-enum](https://github.com/myclabs/php-enum).

## Testing
You can run the tests with:

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email rdlrobot@gmail.com instead of using the issue tracker.

## Credits

- [Vladimir Pyankov](https://github.com/lemax10)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.