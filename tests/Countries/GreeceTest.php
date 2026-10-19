<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Countries\Greece;
use Spatie\Holidays\Holidays;

afterEach(function () {
    CarbonImmutable::setTestNow();
});

it('can calculate hellenic holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'gr', year: 2024)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('resolves ISO and EU codes to the same Greek holidays', function (string $code, int $year) {
    $country = Country::findOrFail($code);

    expect($country)->toBeInstanceOf(Greece::class)
        ->and($country->countryCode())->toBe('gr')
        ->and(Holidays::has($code))->toBeTrue()
        ->and(Holidays::for($code, $year)->get())->toEqual(Holidays::for(Greece::make(), $year)->get());
})->with(['gr', 'el', 'GR', 'EL'])->with([2024, 2025]);
