# Calculate public holidays for a country

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)
[![Tests](https://img.shields.io/github/actions/workflow/status/spatie/holidays/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/holidays/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)

This package can calculate public holidays for a country.

```php
use Spatie\Holidays\Holidays;

// returns an array of Belgian holidays
// for the current year
$holidays = Holidays::for('be')->get();
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/holidays.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/holidays)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/holidays
```

## Supported countries

We support the countries listed in [this directory](https://github.com/spatie/holidays/tree/main/src/Countries). If you want to add a country, please create a pull request.

## Usage

You can get all holidays for a country by using the `get` method.

```php
use Spatie\Holidays\Holidays;
use Spatie\Holidays\Countries\Belgium;

// returns an array of Belgian holidays
// for the current year
$holidays = Holidays::for(Belgium::make())->get(); 
```

Alternatively, you could also pass an [ISO 3166-1](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements) code to the `for` method.
In case of region based holidays, these will not be included. Use a country class instead.

```php
use Spatie\Holidays\Holidays;

// returns an array of Belgian holidays
// for the current year
$holidays = Holidays::for('be')->get();
```

### Getting holidays for a specific year

You can also pass a specific year.

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for(country: 'be', year: 2024))->get();
```

### Getting holidays in a specific language

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for(country: 'be', locale: 'fr'))->get();
```

If the locale is not supported for a country, an exception will be thrown.

### Determining if a date is a holiday 

If you need to see if a date is a holiday, you can use the `isHoliday` method.

```php
use Spatie\Holidays\Holidays;

Holidays::for('be')->isHoliday('2024-01-01'); // true
```

### Getting the name of a holiday

If you need the name of the holiday, you can use the `getName` method.

```php
use Spatie\Holidays\Holidays;

Holidays::for('be')->getName('2024-01-01'); // Nieuwjaar
```

### Determining whether a country is supported

To verify whether a country is supported, you can use the `has` method.

```php
use Spatie\Holidays\Holidays;

Holidays::has('be'); // true
Holidays::has('unknown'); // false
```

### Package limitations
1. Islamic holidays are not supported (yet)

## Contributing

This is a community driven package. If you find any errors, please create an issue or a pull request.

## Adding a new country

1. Create a new class in the `Countries` directory. It should extend the `Country` class.
2. Add a test for the new country in the `tests` directory.
3. Run the tests so a snapshot gets created.
4. Verify the result in the newly created snapshot is correct.
5. If the country has multiple languages, add a file in the `lang/` directory.

In case your country has specific rules for calculating holidays,
for example region specific holidays, you can pass this to the constructor of your country class.

```php
$holidays = Holidays::for(Austria::make(region: 'de-bw'))->get();
```

The value, `de-bw`, will be passed to the region parameter of the constructor of a country.

```php
class Austria extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    protected function allHolidays(int $year): array
    {
        // Here you can use $this->region (or other variables) to calculate holidays
    }
```

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for more details.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Niels Vanpachtenbeke](https://github.com/Nielsvanpach)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
