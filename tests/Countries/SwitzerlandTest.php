<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Switzerland;
use Spatie\Holidays\Holidays;

it('can calculate swiss holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'ch')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

describe('cantons', function () {
    it('can calculate holidays for the canton valais', function (string $language) {

        CarbonImmutable::setTestNowAndTimezone('2024-01-01');

        $holidays = Holidays::for(Switzerland::make('ch-vs', $language))->get();

        expect($holidays)
            ->toBeArray()
            ->not()->toBeEmpty();

        expect(formatDates($holidays))->toMatchSnapshot();
    })->with(['de', 'fr'])->only();


});
