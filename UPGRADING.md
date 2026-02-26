# Upgrading

## From v1 to v2

### Breaking changes

#### PHP 8.4+ required

v2 requires PHP 8.4 or higher. Update your `composer.json` accordingly.

#### `get()` and `getInRange()` now return `Holiday[]`

In v1, `get()` returned an associative array of `name => date` and `getInRange()` returned `date => name`:

```php
// v1
$holidays = Holidays::for('be')->get();
// ['Nieuwjaar' => CarbonImmutable, ...]

$holidays = Holidays::for('be')->getInRange('2024-01-01', '2024-12-31');
// ['2024-01-01' => 'Nieuwjaar', ...]
```

In v2, both methods return an array of `Holiday` objects:

```php
// v2
$holidays = Holidays::for('be')->get();

$holidays[0]->name; // 'Nieuwjaar'
$holidays[0]->date; // CarbonImmutable('2024-01-01')
$holidays[0]->type; // HolidayType::National

json_encode($holidays[0]);
// {"name":"Nieuwjaar","date":"2024-01-01","type":"national","region":null}
```

#### `get()`, `isHoliday()`, and `getName()` no longer accept country/year overrides

In v1, these methods accepted optional `$country` and `$year` parameters that silently created a new instance:

```php
// v1
$h = Holidays::for('be', 2024);
$h->get('nl', 2025);
$h->isHoliday('2024-01-01', 'nl');
$h->getName('2024-01-01', 'nl');
```

In v2, call `Holidays::for()` for each country/year combination:

```php
// v2
Holidays::for('be', 2024)->get();
Holidays::for('nl', 2025)->get();
Holidays::for('nl')->isHoliday('2024-01-01');
Holidays::for('nl')->getName('2024-01-01');
```

#### Denmark country code changed

The Denmark country code has been corrected from `da` to `dk` to match the ISO 3166-1 alpha-2 standard:

```php
// v1
Holidays::for('da')->get();

// v2
Holidays::for('dk')->get();
```

#### Global year range removed

In v1, all countries were limited to years 1970–2037. In v2, this global limit has been removed. Most countries now support any year. Countries that depend on precomputed calendar lookup tables (Islamic, Indian, etc.) declare their own range:

```php
// v1: throws for ANY country outside 1970–2037
Holidays::for('be', year: 2050)->get(); // InvalidYear

// v2: most countries work for any year
Holidays::for('be', year: 2050)->get(); // works

// v2: calendar-dependent countries have their own range
Holidays::for('tr', year: 2050)->get();
// InvalidYear: Only years between 1970 and 2037 are supported for tr.
```

### Other improvements

These are internal changes that don't require any action on your part.

- **`Holiday::national()` and `Holiday::religious()` accept both strings and `CarbonImmutable`** — dates can be passed as strings (e.g., `"{$year}-01-01"`) or `CarbonImmutable` instances. The `createDate()` helper in the `Country` base class provides type-safe date parsing with explicit error handling.
- **Translation system simplified** — the `HasTranslations` interface and `Translatable` trait have been removed. Translations are now built into the `Country` base class. The `defaultLocale()` method is now `protected`.
- **Translation file paths changed** — translation files moved from `lang/{hyphenated-class-name}/` to `lang/{countryCode}/` (e.g. `lang/germany/` became `lang/de/`).
- **`Observable` trait renamed to `HasObservedHolidays`** — its methods now only accept `CarbonInterface` dates instead of strings and `$year` parameters.
- **`Islamic` interface tightened** — `islamicHolidays()` return type changed from `array<string, string|CarbonImmutable|CarbonPeriod>` to `array<string, CarbonImmutable>`.
- **Calendar lookup constants** on countries like Albania, Turkey, and India are now `protected const` instead of `public const`.
- **`supportedYearRange()`** — countries with calendar lookup tables now declare their supported year range explicitly.
- **Performance** — country discovery now uses a static `CountryRegistry` map instead of filesystem scanning (`glob()`), and date parsing no longer runs regex/string-matching on every holiday.
- **`ResolvesCalendarDates` trait** deduplicates shared date resolution logic across Islamic, Indian, Chinese, and Nepali calendar traits.
- **`HasRegions` interface** standardizes how countries declare and validate regional holiday support.
- **`Holiday` value object and `HolidayType` enum** provide structured, JSON-serializable return data instead of plain arrays.
- **`region` parameter on `Holidays::for()`** allows passing a region code directly without constructing a country instance.
