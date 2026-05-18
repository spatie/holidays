<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate ethiopian holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'et')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatEthiopianDates($holidays))->toMatchSnapshot();
});

it('adjusts january holidays before the ethiopian and gregorian calendars sync', function () {
    $holidays2024 = Holidays::for(country: 'et', year: 2024)->get();
    $holidays2028 = Holidays::for(country: 'et', year: 2028)->get();

    expect(findDate($holidays2024, 'Ethiopian Christmas')?->toDateString())->toBe('2024-01-08')
        ->and(findDate($holidays2024, 'Epiphany')?->toDateString())->toBe('2024-01-20')
        ->and(findDate($holidays2028, 'Ethiopian Christmas')?->toDateString())->toBe('2028-01-08')
        ->and(findDate($holidays2028, 'Epiphany')?->toDateString())->toBe('2028-01-20');
});

it('can get ethiopian holidays in amharic', function () {
    $holidays = Holidays::for(country: 'et', year: 2024, locale: 'am')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatEthiopianDates($holidays))->toMatchSnapshot();
});

it('adjusts meskerem holidays before gregorian leap years', function () {
    $holidays2023 = Holidays::for(country: 'et', year: 2023)->get();
    $holidays2024 = Holidays::for(country: 'et', year: 2024)->get();

    expect(findDate($holidays2023, 'Ethiopian New Year')?->toDateString())->toBe('2023-09-12')
        ->and(findDate($holidays2023, 'Meskel')?->toDateString())->toBe('2023-09-28')
        ->and(findDate($holidays2024, 'Ethiopian New Year')?->toDateString())->toBe('2024-09-11')
        ->and(findDate($holidays2024, 'Meskel')?->toDateString())->toBe('2024-09-27');
});

it('uses ethiopian dates for 2028 timkat and mawlid', function () {
    $holidays = Holidays::for(country: 'et', year: 2028)->get();

    expect(findDate($holidays, 'Epiphany')?->toDateString())->toBe('2028-01-20')
        ->and(findDate($holidays, 'Mawlid')?->toDateString())->toBe('2028-08-03');
});

function formatEthiopianDates(array $holidays): array
{
    $dates = formatDates($holidays);

    usort($dates, static fn (array $a, array $b): int => [$a['date'], $a['name']] <=> [$b['date'], $b['name']]);

    return $dates;
}
