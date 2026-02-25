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
