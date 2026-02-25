# Calculate public holidays for a country

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)
[![Tests](https://img.shields.io/github/actions/workflow/status/spatie/holidays/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/spatie/holidays/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/holidays.svg?style=flat-square)](https://packagist.org/packages/spatie/holidays)

This package can calculate public holidays for a country.

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for('be')->get();

$holidays[0]->name; // 'Nieuwjaar'
$holidays[0]->date; // CarbonImmutable('2024-01-01')
$holidays[0]->type; // HolidayType::National
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

This package requires PHP 8.4+.

## Supported countries

We support the countries listed in [this directory](https://github.com/spatie/holidays/tree/main/src/Countries). If you want to add a country, please create a pull request. See [Adding a new country](#adding-a-new-country) for a guide.

## Usage

You can get all holidays for a country by using the `get` method. It returns an array of `Holiday` objects.

```php
use Spatie\Holidays\Holidays;

$holidays = Holidays::for('be')->get();

foreach ($holidays as $holiday) {
    $holiday->name; // 'Nieuwjaar'
    $holiday->date; // CarbonImmutable instance
    $holiday->type; // HolidayType::National
}
```

You can pass a country instance or an [ISO 3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements) code:

```php
use Spatie\Holidays\Countries\Belgium;

$holidays = Holidays::for(Belgium::make())->get();
$holidays = Holidays::for('be')->get();
```

The `Holiday` object implements `JsonSerializable`:

```php
json_encode($holidays[0]);
// {"name":"Nieuwjaar","date":"2024-01-01","type":"national","region":null}
```

### Getting holidays for a specific year

```php
$holidays = Holidays::for(country: 'be', year: 2024)->get();
```

### Getting holidays between two dates

The `getInRange` method returns all holidays between two dates (inclusive). Dates are swappable — the lower date is always used as the start.

```php
$holidays = Holidays::for('be')->getInRange('2024-01-01', '2024-12-31');
```

You can also use shorthand formats:

```php
$holidays = Holidays::for('be')->getInRange('2024', '2025');     // full years
$holidays = Holidays::for('be')->getInRange('2024-06', '2025-05'); // year-month
```

### Getting holidays in a specific language

```php
$holidays = Holidays::for(country: 'be', locale: 'fr')->get();
```

If no translation file exists for the given locale, the original holiday names are returned.

### Regional holidays

Some countries have region-specific holidays. You can pass a region code to the `for` method:

```php
$holidays = Holidays::for('de', year: 2024, region: 'DE-BW')->get();
```

Or use the country class directly:

```php
use Spatie\Holidays\Countries\Germany;

$holidays = Holidays::for(Germany::make('DE-BW'), year: 2024)->get();
```

To discover which regions a country supports:

```php
use Spatie\Holidays\Countries\Germany;

Germany::regions(); // ['DE-BW', 'DE-BY', 'DE-BE', ...]
```

Countries that support regions: Australia, Bosnia and Herzegovina, France, Germany, Malaysia, Spain, Switzerland.

### Determining if a date is a holiday

```php
Holidays::for('be')->isHoliday('2024-01-01'); // true
```

### Getting the name of a holiday

```php
Holidays::for('be')->getName('2024-01-01'); // 'Nieuwjaar'
```

### Determining whether a country is supported

```php
Holidays::has('be'); // true
Holidays::has('unknown'); // false
```

## Adding a new country

This is a community driven package. If you find any errors, please create a pull request with the fix, or at least open an issue.

### Basic country

Create a new class in `src/Countries` that extends `Country`. At minimum, you need to implement `countryCode()` and `allHolidays()`:

```php
use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Country;

class MyCountry extends Country
{
    public function countryCode(): string
    {
        return 'xx'; // ISO 3166-1 alpha-2 code
    }

    protected function allHolidays(int $year): array
    {
        return [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Christmas' => CarbonImmutable::createFromDate($year, 12, 25),
        ];
    }
}
```

All dates must be `CarbonImmutable` instances. For Easter-based holidays, use the `easter()` or `orthodoxEaster()` helpers:

```php
protected function allHolidays(int $year): array
{
    $easter = $this->easter($year);

    return [
        'Good Friday' => $easter->subDays(2),
        'Easter Monday' => $easter->addDay(),
    ];
}
```

For relative dates, use `CarbonImmutable::parse()`:

```php
'Labor Day' => CarbonImmutable::parse("first monday of September {$year}"),
```

If your country defines holidays in a non-English language, override `defaultLocale()`:

```php
protected function defaultLocale(): string
{
    return 'de';
}
```

### Regional holidays

If your country has region-specific holidays, implement the `HasRegions` interface:

```php
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;

class MyCountry extends Country implements HasRegions
{
    protected function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, static::regions())) {
            throw InvalidRegion::notFound($region);
        }
    }

    public static function regions(): array
    {
        return ['XX-A', 'XX-B', 'XX-C'];
    }

    public function region(): ?string
    {
        return $this->region;
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->nationalHolidays($year),
            $this->regionHolidays($year),
        );
    }

    protected function regionHolidays(int $year): array
    {
        return match ($this->region) {
            'XX-A' => ['Regional Day' => CarbonImmutable::createFromDate($year, 6, 1)],
            default => [],
        };
    }
}
```

### Observed holidays

If your country moves holidays that fall on a weekend to the next weekday, use the `HasObservedHolidays` trait:

```php
use Spatie\Holidays\Concerns\HasObservedHolidays;

class MyCountry extends Country
{
    use HasObservedHolidays;
}
```

The trait provides these methods (each returns `null` if no shift applies):

- `weekendToNextMonday(CarbonInterface $date)` — shifts Saturday/Sunday to Monday
- `sundayToNextMonday(CarbonInterface $date)` — shifts Sunday to Monday
- `observedChristmasDay(CarbonInterface $date)` — Saturday to Monday, Sunday to Tuesday
- `observedBoxingDay(CarbonInterface $date)` — Saturday to Monday, Sunday to Tuesday

### Calendar systems

For countries that use Islamic, Chinese, Indian, or Nepali calendar dates, use the corresponding calendar trait. These traits rely on precomputed lookup tables defined as `protected const` arrays on your country class:

```php
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Contracts\Islamic;

class MyCountry extends Country implements Islamic
{
    use IslamicCalendar;

    protected const eidAlFitr = [
        2024 => '04-10',
        2025 => '03-30',
        // ...
    ];

    protected const eidAlAdha = [
        2024 => '06-16',
        2025 => '06-06',
        // ...
    ];
}
```

Countries with lookup tables must declare their supported year range:

```php
protected function supportedYearRange(): array
{
    return [2024, 2037]; // [min, max] based on your lookup data
}
```

For multi-day holidays (like Eid), use `convertPeriods()` to expand a `CarbonPeriod` into individual named days:

```php
$this->convertPeriods('Eid al-Fitr', $year, $this->eidAlFitr($year)[0], includeEve: true);
```

Available calendar traits: `IslamicCalendar`, `ChineseCalendar`, `IndianCalendar`, `NepaliCalendar`.

### Translations

To add translations for a country, create a JSON file at `lang/{countryCode}/{locale}/holidays.json`:

```json
{
    "New Year's Day": "Jour de l'An",
    "Christmas": "Noël"
}
```

The keys must match the holiday names returned by `allHolidays()`.

### Register the country

Add your new country class to the `CountryRegistry` in `src/CountryRegistry.php`.

### Testing

1. Create a test file in `tests/Countries/`:

```php
use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate my country holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'xx')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
```

2. Run `vendor/bin/pest --update-snapshots` to generate the snapshot.
3. Verify the generated snapshot in `tests/.pest/snapshots/` is correct.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Upgrading

Please see [UPGRADING](UPGRADING.md) for how to upgrade to a new major version.

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
