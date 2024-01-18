<?php

use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Holidays;

use function Laravel\Prompts\select;

require __DIR__.'/vendor/autoload.php';

$countries = [];

foreach (glob(__DIR__.'/src/Countries/*.php') as $filename) { // @phpstan-ignore-line
    $countryClass = '\\Spatie\\Holidays\\Countries\\'.basename($filename, '.php');

    if (basename($filename) === 'Country.php') {
        continue;
    }

    $countries[$countryClass] = str_replace('\\Spatie\\Holidays\\Countries\\', '', $countryClass);
}

/** @var Country $class */
$class = select('Select a country', $countries);

$result = collect(Holidays::for($class::make())->get())
    ->map(fn (array $holiday) => [
        'name' => $holiday['name'],
        'date' => $holiday['date']->format('Y-m-d'), // @phpstan-ignore-line
    ])->toArray();

dd($result);
