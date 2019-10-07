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
## Installation

You can install the package via composer:

```bash
composer require LeMaX10/laravel-enums
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