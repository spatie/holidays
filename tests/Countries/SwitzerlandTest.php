<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Switzerland;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holidays;

dataset('cantons', [
    'ag',
    'ai',
    'ar',
    'be',
    'bl',
    'bs',
    'fr',
    'ge',
    'gl',
    'gr',
    'ju',
    'lu',
    'ne',
    'nw',
    'ow',
    'sg',
    'sh',
    'so',
    'sz',
    'tg',
    'ti',
    'ur',
    'vd',
    'vs',
    'zg',
    'zh',
]);

dataset('languages', [
    'de',
    'fr',
    'it'
]);

it('can calculate swiss holidays', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'ch')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate holidays for a specified canton', function ($canton) {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $switzerland = new Switzerland(region: "ch-$canton");

    $holidays = Holidays::for($switzerland)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with('cantons');


it('throws an error when an invalid region is given', function () {
    $switzerland = new Switzerland('ch-xx');
    $holidays = Holidays::for($switzerland)->get();

})->throws(InvalidRegion::class);


it('does not have ephinay holiday at zh', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $switzerland = new Switzerland('ch-zh');
    $holidays = Holidays::for($switzerland);

    expect($holidays->isHoliday('2024-01-06'))->toBeFalse();
});

describe('special holidays with conditions', function () {

    it('has holidays in on 12-26 if christmas is not on a monday or friday at', function (string $canton, int $year, bool $isHoliday) {
        CarbonImmutable::setTestNowAndTimezone("$year-01-01");

        $switzerland = new Switzerland("ch-$canton");
        $holidays = Holidays::for($switzerland);

        expect($holidays->isHoliday("$year-12-26"))->toBe($isHoliday);
    })
        ->with(['ai', 'ar'])
        ->with([
            [2017, false],
            [2023, false],
            [2024, true],
            [2025, true],
            [2026, false],
        ]);

    it('has sets jeune genevois to thursday following the first sunday in september', function (int $year, string $date) {
        CarbonImmutable::setTestNowAndTimezone("$year-01-01");

        $switzerland = new Switzerland("ch-ge");
        $holidays = Holidays::for($switzerland);

        expect($holidays->isHoliday($date))->toBeTrue();
    })
        ->with([
            [2017, '2017-09-07'],
            [2023, '2023-09-07'],
            [2024, '2024-09-05'],
            [2025, '2025-09-11'],
            [2026, '2026-09-10'],
        ]);
});

it('celebrates labour day on 1st of may', function (string $canton) {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $switzerland = new Switzerland("ch-$canton");
    $holidays = Holidays::for($switzerland);

    expect($holidays->isHoliday('2024-05-01'))->toBeTrue();
})
    ->with([
        'zh',
        'so',
        'bs',
        'bl',
        'sh',
        'ag',
        'tg',
        'ne',
        'ju',
        'ti'
    ]);

