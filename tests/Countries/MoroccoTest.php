<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holidays;
use Spatie\Holidays\HolidayType;

it('can calculate morocco holidays 2024', function () {
    CarbonImmutable::setTestNowAndTimezone('2024-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate morocco holidays 2023', function () {
    CarbonImmutable::setTestNowAndTimezone('2023-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate morocco holidays 2025', function () {
    CarbonImmutable::setTestNowAndTimezone('2025-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can calculate morocco holidays 2026', function () {
    CarbonImmutable::setTestNowAndTimezone('2026-01-01');

    $holidays = Holidays::for(country: 'ma')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('uses announced Moroccan dates without changing national holiday names or filters', function (int $year, string $fitr, string $adha, string $newYear, string $mawlid) {
    $calendar = Holidays::for('ma', $year);
    $nationalHolidays = $calendar->get(HolidayType::National);

    expect($nationalHolidays)->toEqual($calendar->get());
    expect($calendar->get(HolidayType::Religious))->toBeEmpty();

    foreach ([
        'Eid al-Fitr' => $fitr,
        'Eid al-Adha' => $adha,
        'Islamic New Year' => $newYear,
        'Birthday of the Prophet Muhammad' => $mawlid,
    ] as $name => $date) {
        expect(findDate($nationalHolidays, $name)?->toDateString())->toBe("{$year}-{$date}");
        expect($calendar->getName("{$year}-{$date}"))->toBe($name);

        if ($name !== 'Islamic New Year') {
            $secondDay = CarbonImmutable::parse("{$year}-{$date}")->addDay()->toDateString();

            expect(findDate($nationalHolidays, "{$name} 2")?->toDateString())->toBe($secondDay);
            expect($calendar->getName($secondDay))->toBe("{$name} 2");
        }
    }
})->with([
    [2023, '04-22', '06-29', '07-19', '09-28'],
    [2024, '04-10', '06-17', '07-07', '09-16'],
    [2025, '03-31', '06-07', '06-27', '09-05'],
    [2026, '03-20', '05-27', '06-17', '08-25'],
]);

it('does not retain the displaced calculation dates as holidays', function (string $date) {
    expect(Holidays::for('ma')->isHoliday($date))->toBeFalse();
})->with(['2023-04-21', '2023-09-27', '2024-07-08', '2026-08-27']);

it('adds Unity Day only from its first public holiday in 2026', function (int $year, ?string $name) {
    $calendar = Holidays::for('ma', $year);

    expect($calendar->getName("{$year}-10-31"))->toBe($name);
    expect($calendar->isHoliday("{$year}-10-31"))->toBe($name !== null);
    expect($calendar->isHoliday("{$year}-10-30"))->toBeFalse();
    expect($calendar->isHoliday("{$year}-11-01"))->toBeFalse();
})->with([[2024, null], [2025, null], [2026, 'Unity Day'], [2027, 'Unity Day']]);

it('preserves second-day translations and translates Unity Day', function (string $locale, string $mawlid, string $fitr, string $adha, string $unity) {
    $calendar = Holidays::for('ma', 2026, $locale);

    expect($calendar->getName('2026-08-26'))->toBe($mawlid);
    expect($calendar->getName('2026-03-21'))->toBe($fitr);
    expect($calendar->getName('2026-05-28'))->toBe($adha);
    expect($calendar->getName('2026-10-31'))->toBe($unity);
})->with([
    ['fr', 'Aid Al Mawlid 2', 'Aid Al Fitr 2', 'Aid Al Adha 2', 'Aid Al Wahda'],
    ['ar', 'تاني ايام عيد المولد النبوي', 'تاني ايام عيد الفطر', 'تاني ايام عيد الأضحى', 'عيد الوحدة'],
]);

it('preserves the existing calculation outside corrected years', function (int $year, string $date) {
    expect(Holidays::for('ma', $year)->getName($date))->toBe('Eid al-Fitr');
})->with([[1976, '1976-09-25'], [2022, '2022-05-03'], [2027, '2027-03-10']]);

it('still rejects years before the existing lower boundary', function () {
    Holidays::for('ma', 1975)->get();
})->throws(InvalidYear::class);
