<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate tunisian holidays 2024', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'tn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate tunisian holidays 2025', function () {
    CarbonImmutable::setTestNow('2025-01-01');

    $holidays = Holidays::for(country: 'tn')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

//it('can calculate tunisian holidays list', function () {
//
//    $result = [];
//    for ($i = 1970; $i <= 2037; $i++) {
//        CarbonImmutable::setTestNowAndTimezone("$i-01-01");
//        $holidays = Holidays::for(country: 'tn')->get();
//        //dd($holidays);
//        $result[$i] = formatDates($holidays)[0]['date'];
//    }
//    //dd($result);
//    file_put_contents('fitr.json', json_encode($result));
//    //file_put_contents('hijri.bin', serialize($result));
//});

