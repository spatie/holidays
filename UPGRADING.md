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
