# Calculate public holidays for a country

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)
[![Tests](https://img.shields.io/github/actions/workflow/status/spatie/holidays/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/holidays/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)

**THIS PACKAGE IS IN DEVELOPMENT, DON'T USE IT IN PRODUCTION (YET)**

Calculate which days you don't have to work!

```php
use Spatie\Holidays\Holiday;

$holidays = Holidays::get(); // returns an array of holidays for the current year
```

Or for a specific country and year.

```php
use Spatie\Holidays\Holiday;

$holidays = Holidays::get(country: 'be', year: 2024);
```

If you need to see if a date is a holiday, you can use the `isHoliday` method.

```php
use Spatie\Holidays\Holiday;

Holidays::new()->isHoliday('2024-01-01'); // true
```

If you need the name of the holiday, you can use the `getHolidayName` method.

```php
use Spatie\Holidays\Holiday;

Holidays::new()->getName('2024-01-01'); // Nieuwjaar
```

## Supported countries
At the moment only these countries are supported.
You can send a PR for yours!

- [x] Belgium

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/holidays.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/holidays)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/holidays
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
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
