# Upgrading to v2

## `get()`, `isHoliday()`, and `getName()` no longer accept country/year overrides

In v1, these methods accepted optional `$country` and `$year` parameters that silently created a new instance:

```php
// v1: confusing — silently discards the 'be'/2024 context
$h = Holidays::for('be', 2024);
$h->get('nl', 2025);
$h->isHoliday('2024-01-01', 'nl');
$h->getName('2024-01-01', 'nl');
```

In v2, call `Holidays::for()` for each country/year combination:

```php
// v2: explicit
Holidays::for('be', 2024)->get();
Holidays::for('nl', 2025)->get();
Holidays::for('nl')->isHoliday('2024-01-01');
Holidays::for('nl')->getName('2024-01-01');
```

## `allHolidays()` must return `CarbonImmutable` values

In v1, the `allHolidays()` method in country classes could return a mix of `string` and `CarbonImmutable` values, with the base `Country::get()` handling the conversion:

```php
// v1: strings were auto-parsed by Country::get()
protected function allHolidays(int $year): array
{
    return [
        "New Year's Day" => '01-01',
        'Easter Monday' => $this->easter($year)->addDay(),
    ];
}
```

In v2, all values must be `CarbonImmutable` instances:

```php
// v2: explicit CarbonImmutable values
protected function allHolidays(int $year): array
{
    return [
        "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
        'Easter Monday' => $this->easter($year)->addDay(),
    ];
}
```

For relative dates (like "first monday of September"), use `CarbonImmutable::parse()`:

```php
// v1
'Labor Day' => 'first monday of September',

// v2
'Labor Day' => CarbonImmutable::parse('first monday of September ' . $year),
```

This also means any custom helper methods that accepted `'MM-DD'` strings must now work with `CarbonImmutable` directly.

## Regions: `HasRegions` interface and `Holidays::for()` region parameter

In v1, region-based holidays required creating a country instance directly:

```php
// v1: only way to use regions
$holidays = Holidays::for(Germany::make('DE-BW'))->get();
```

In v2, you can pass a `region` parameter to `Holidays::for()`:

```php
// v2: region through the string API
$holidays = Holidays::for('de', year: 2024, region: 'DE-BW')->get();

// v2: still works with country instances
$holidays = Holidays::for(Germany::make('DE-BW'), year: 2024)->get();
```

Countries with region support now implement the `HasRegions` interface, which provides:
- `regions()` — returns an array of valid region codes
- `region()` — returns the current region (or null)

All regional countries now validate region codes in the constructor and throw `InvalidRegion` for unknown codes. If you were passing invalid region codes that were silently ignored in v1, they will now throw an exception.

The Netherlands no longer accepts a `$region` constructor parameter (it was never used).

## `Observable` trait methods no longer accept strings or `$year`

In v1, `weekendToNextMonday()` and `sundayToNextMonday()` accepted a string date and a `$year` parameter:

```php
// v1
$this->weekendToNextMonday('01-01', $year);
$this->sundayToNextMonday('12-25', $year);
```

In v2, these methods only accept a `CarbonInterface` instance and the `$year` parameter has been removed:

```php
// v2
$this->weekendToNextMonday(CarbonImmutable::createFromDate($year, 1, 1));
$this->sundayToNextMonday(CarbonImmutable::createFromDate($year, 12, 25));
```

## Calendar lookup constants are now `protected`

The calendar date lookup arrays on `Albania`, `Turkey`, and `India` (e.g. `eidAlFitr`, `eidAlAdha`, `holiHolidays`, etc.) have been changed from `public const` to `protected const`. If you were referencing these constants externally, use the country's public holiday API instead.

## `Observable` trait renamed to `HasObservedHolidays`

The `Observable` trait has been renamed to `HasObservedHolidays`:

```php
// v1
use Spatie\Holidays\Concerns\Observable;
use Observable;

// v2
use Spatie\Holidays\Concerns\HasObservedHolidays;
use HasObservedHolidays;
```

The `observedChristmasDay()` and `observedBoxingDay()` methods now accept a `CarbonInterface` date instead of `int $year`:

```php
// v1
$this->observedChristmasDay($year);
$this->observedBoxingDay($year);

// v2
$this->observedChristmasDay($christmasDate);
$this->observedBoxingDay($boxingDayDate);
```

## Translation system: `HasTranslations` and `Translatable` removed

In v1, countries opted into translation support by implementing `HasTranslations` and using the `Translatable` trait:

```php
// v1
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Concerns\Translatable;

class Germany extends Country implements HasTranslations
{
    use Translatable;

    public function defaultLocale(): string
    {
        return 'de';
    }
}
```

In v2, translation is built into the `Country` base class. The `HasTranslations` interface and `Translatable` trait have been removed. Countries that define holidays in a non-English language override the `protected defaultLocale()` method:

```php
// v2
class Germany extends Country
{
    protected function defaultLocale(): string
    {
        return 'de';
    }
}
```

Any country can now have translations without code changes — just add a JSON file at `lang/{countryCode}/{locale}/holidays.json`.

### Translation file paths changed

Translation files have moved from `lang/{hyphenated-class-name}/` to `lang/{countryCode}/`:

```
# v1
lang/germany/en/holidays.json
lang/bosnia-and-herzegovina/en/holidays.json

# v2
lang/de/en/holidays.json
lang/ba/en/holidays.json
```

If you had custom translation files, move them to the new paths.
