<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Brazil;
use Spatie\Holidays\Holidays;

it('can calculate brazil holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'br')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('does not include state holidays without a region', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for('br')->isHoliday('2024-07-09'))->toBeFalse(); // SP Revolução Constitucionalista
    expect(Holidays::for('br')->isHoliday('2024-07-02'))->toBeFalse(); // BA Independência da Bahia
    expect(Holidays::for('br')->isHoliday('2024-09-20'))->toBeFalse(); // RS Revolução Farroupilha
});

it('can calculate São Paulo state holiday Revolução Constitucionalista', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for(Brazil::make('BR-SP'))->isHoliday('2024-07-09'))->toBeTrue();
});

it('can calculate Bahia state holiday Independência da Bahia', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for(Brazil::make('BR-BA'))->isHoliday('2024-07-02'))->toBeTrue();
});

it('can calculate Rio Grande do Sul state holiday Revolução Farroupilha', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for(Brazil::make('BR-RS'))->isHoliday('2024-09-20'))->toBeTrue();
});

it('can calculate Espírito Santo moveable holiday Nossa Senhora da Penha', function () {
    // Easter 2024 = March 31; +8 days = April 8
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for(Brazil::make('BR-ES'))->isHoliday('2024-04-08'))->toBeTrue();
});

it('can calculate Espírito Santo moveable holiday Nossa Senhora da Penha in 2027', function () {
    // Easter 2027 = March 28; +8 days = April 5
    CarbonImmutable::setTestNow('2027-01-01');

    expect(Holidays::for(Brazil::make('BR-ES'))->isHoliday('2027-04-05'))->toBeTrue();
});

it('can calculate Rio de Janeiro state holiday São Jorge', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for(Brazil::make('BR-RJ'))->isHoliday('2024-04-23'))->toBeTrue();
});

it('can calculate Pernambuco state holiday Revolução Pernambucana', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    expect(Holidays::for(Brazil::make('BR-PE'))->isHoliday('2024-03-06'))->toBeTrue();
});

it('national holidays are still present when a region is specified', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(Brazil::make('BR-SP'));

    expect($holidays->isHoliday('2024-09-07'))->toBeTrue(); // Independência do Brasil
    expect($holidays->isHoliday('2024-11-15'))->toBeTrue(); // Proclamação da República
    expect($holidays->isHoliday('2024-12-25'))->toBeTrue(); // Natal
});

/*
 * This test will check regional holidays for all Brazilian states.
 * Sources:
 *   - https://pt.wikipedia.org/wiki/Feriados_no_Brasil
 *   - https://blog.feriados.com.br/feriados-estaduais/
 */
it('can calculate brazil holidays for other regions', function (string $region, int $totalHolidays) {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(Brazil::make("BR-{$region}"))->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(count($holidays))->toBe($totalHolidays);

    expect(formatDates($holidays))->toMatchSnapshot();
})->with([
    ['AC', 16], // 12 national + 4 state (Jan 23, Jun 15, Sep 5, Nov 17)
    ['AL', 15], // 12 national + 3 state (Jun 24, Jun 29, Sep 16)
    ['AP', 15], // 12 national + 3 state (Mar 19, Jul 25, Oct 5)
    ['AM', 14], // 12 national + 2 state (Sep 5, Dec 8)
    ['BA', 13], // 12 national + 1 state (Jul 2)
    ['CE', 14], // 12 national + 2 state (Mar 19, Mar 25)
    ['DF', 13], // 12 national + 1 state (Nov 30)
    ['ES', 13], // 12 national + 1 state (Easter+8 = Apr 8 in 2024)
    ['GO', 15], // 12 national + 3 state (May 24, Jul 26, Oct 24)
    ['MA', 14], // 12 national + 2 state (Jul 28, Dec 8)
    ['MG', 12], // 12 national + 0 state
    ['MS', 13], // 12 national + 1 state (Oct 11)
    ['MT', 12], // 12 national + 0 state
    ['PA', 14], // 12 national + 2 state (Aug 15, Dec 8)
    ['PB', 13], // 12 national + 1 state (Aug 5)
    ['PE', 14], // 12 national + 2 state (Mar 6, Jun 24)
    ['PI', 14], // 12 national + 2 state (Mar 13, Oct 19)
    ['PR', 13], // 12 national + 1 state (Dec 19)
    ['RJ', 13], // 12 national + 1 state (Apr 23)
    ['RN', 14], // 12 national + 2 state (Aug 7, Oct 3)
    ['RO', 14], // 12 national + 2 state (Jan 4, Jun 18)
    ['RR', 13], // 12 national + 1 state (Oct 5)
    ['RS', 13], // 12 national + 1 state (Sep 20)
    ['SC', 14], // 12 national + 2 state (Aug 11, Nov 25)
    ['SE', 13], // 12 national + 1 state (Jul 8)
    ['SP', 13], // 12 national + 1 state (Jul 9)
    ['TO', 14], // 12 national + 2 state (Sep 8, Oct 5)
]);
