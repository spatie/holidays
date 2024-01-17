# Calculate public holidays for a country

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)
[![Tests](https://img.shields.io/github/actions/workflow/status/spatie/holidays/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/holidays/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)

This package can calculate public holidays for a country.

```php
use Spatie\Holidays\Holiday;

$holidays = Holidays::for('be')->get(); // returns an array of Belgian holidays for the current year
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
use Spatie\Holidays\Holiday;

$holidays = Holidays::for('be')->get(); // returns an array of Belgian holidays for the current year
```

Alternatively, you could also pass an instance of `Country` to the `for` method.

```php
use Spatie\Holidays\Holiday;
use Spatie\Holidays\Countries\Belgium;

$holidays = Holidays::for(Belgium::make())->get(); // returns an array of Belgian holidays for the current year
```

### Getting holidays for a specific year

You can also pass a specific year.

```php
use Spatie\Holidays\Holiday;

$holidays = Holidays::for(country: 'be', year: 2024))->get();
```

### Determining if a date is a holiday 

If you need to see if a date is a holiday, you can use the `isHoliday` method.

```php
use Spatie\Holidays\Holiday;

Holidays::for('be')->isHoliday('2024-01-01'); // true
```

### Getting the name of a holiday

If you need the name of the holiday, you can use the `getName` method.

```php
use Spatie\Holidays\Holiday;

Holidays::for('be')->getName('2024-01-01'); // Nieuwjaar
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Niels Vanpachtenbeke](https://github.com/Nielsvanpach)
- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
