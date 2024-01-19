<?php

use Spatie\Holidays\Countries\Country;

it('can compute Eid al-Fitr date correctly', function (int $year, string $date) {
    expect(Country::eidAlFitr($year)->format('Y-m-d'))->toBe($date);
})->with([
    [2024, '2024-04-09'],
    [2020, '2020-05-24'],
    [2009, '2009-09-21'],
    [1995, '1995-03-02']
]);


it('can compute Eid al-Adha date correctly', function (int $year, string $date) {
    expect(Country::eidAlAdha($year)->format('Y-m-d'))->toBe($date);
})->with([
    [2024, '2024-06-16'],
    [2023, '2023-06-28'],
    [2019, '2019-08-11'],
    [2007, '2007-12-20'],
    [1994, '1994-05-20']
]);
