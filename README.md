# Calculate public holidays for a country

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)
[![Tests](https://img.shields.io/github/actions/workflow/status/spatie/holidays/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/holidays/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)

This package can calculate public holidays for a country.

```php
use Spatie\Holidays\Holidays;

// returns an array of Holiday objects for the current year
$holidays = Holidays::for('be')->get();

$holidays[0]->name; // 'Nieuwjaar'
$holidays[0]->date; // CarbonImmutable('2024-01-01')
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

You can get all holidays for a country by using the `get` method. It returns an array of `Holiday` objects.

```php
use Spatie\Holidays\Holidays;
use Spatie\Holidays\Countries\Belgium;

// returns Holiday[] for the current year
$holidays = Holidays::for(Belgium::make())->get();

foreach ($holidays as $holiday) {
    echo $holiday->name;       // 'Nieuwjaar'
    echo $holiday->date;       // CarbonImmutable instance
    echo $holiday->type->value; // 'national'
}
```

Alternatively, you could also pass an [ISO 3166-1](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements) code to the `for` method.

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for('be')->get();
```

The `Holiday` object implements `JsonSerializable`, so you can easily convert it to JSON:

```php
json_encode($holidays[0]);
// {"name":"Nieuwjaar","date":"2024-01-01","type":"national","region":null}
```

### Getting holidays for a specific year

You can also pass a specific year.

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for(country: 'be', year: 2024)->get();
```

### Getting holidays between two dates

You can also get all holidays between two dates (inclusive). This also returns `Holiday[]`.

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for('be')->getInRange('2023-06-01', '2024-05-31');
```

### Getting holidays in a specific language

```php
$holidays = Holidays::for(country: 'be', locale: 'fr')->get();
```

If no translation file exists for the given locale, the original holiday names are returned.

### Regional holidays

Some countries have region-specific holidays. You can pass a region code to the `for` method:

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for('de', year: 2024, region: 'DE-BW')->get();
```

Or use the country class directly:

```php
use Spatie\Holidays\Countries\Germany;

$holidays = Holidays::for(Germany::make('DE-BW'), year: 2024)->get();
```

To discover which regions a country supports, use the `HasRegions` interface:

```php
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Countries\Germany;

Germany::regions(); // ['DE-BW', 'DE-BY', 'DE-BE', ...]
```

Countries that support regions: Australia, Bosnia and Herzegovina, France, Germany, Malaysia, Spain, Switzerland.

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

## Contributing

This is a community driven package. If you find any errors, please create a pull request with the fix, or at least open an issue.

## Adding a new country

1. Create a new class in the `Countries` directory. It should extend the `Country` class.
2. Add a test for the new country in the `tests` directory.
3. Run the tests so a snapshot gets created.
4. Verify the result in the newly created snapshot is correct.
5. If the country has multiple languages, add a translation file at `lang/{countryCode}/{locale}/holidays.json`.

If your country has region-specific holidays, implement the `HasRegions` interface:

```php
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Germany extends Country implements HasRegions
{
    protected function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, static::regions())) {
            throw InvalidRegion::notFound($region);
        }
    }

    public static function regions(): array
    {
        return ['DE-BW', 'DE-BY', 'DE-BE', /* ... */];
    }

    public function region(): ?string
    {
        return $this->region;
    }
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
