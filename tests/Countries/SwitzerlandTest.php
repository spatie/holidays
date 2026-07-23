<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Switzerland;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holidays;

it('can calculate swiss holidays', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(country: 'ch')->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can get swiss holidays for a specified region (zh)', function () {
    CarbonImmutable::setTestNow('2024-01-01');

    $switzerland = new Switzerland(region: 'ch-zh');

    $holidays = Holidays::for($switzerland)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can get swiss holidays for every region', function (string $region) {
    CarbonImmutable::setTestNow('2024-01-01');

    $holidays = Holidays::for(Switzerland::make($region))->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
})->with(Switzerland::regions());

it('moves the Näfelser Fahrt (Glarus) out of Holy Week', function () {
    // In 2024 the first Thursday of April is not in Holy Week, so the date is unchanged.
    $holidays = Holidays::for(Switzerland::make('ch-gl'), year: 2024)->get();
    expect(findDate($holidays, 'Näfelser Fahrt')?->format('Y-m-d'))->toBe('2024-04-04');

    // In 2026 the first Thursday of April (2 April) is Maundy Thursday, so it moves a week later.
    $holidays = Holidays::for(Switzerland::make('ch-gl'), year: 2026)->get();
    expect(findDate($holidays, 'Näfelser Fahrt')?->format('Y-m-d'))->toBe('2026-04-09');
});

it('calculates canton-specific swiss holidays', function () {
    $ticino = Holidays::for(Switzerland::make('ch-ti'), year: 2024)->get();
    expect(findDate($ticino, 'Peter und Paul')?->format('Y-m-d'))->toBe('2024-06-29');

    $obwalden = Holidays::for(Switzerland::make('ch-ow'), year: 2024)->get();
    expect(findDate($obwalden, 'Bruderklausenfest')?->format('Y-m-d'))->toBe('2024-09-25');

    $jura = Holidays::for(Switzerland::make('ch-ju'), year: 2024)->get();
    expect(findDate($jura, 'Fest der Unabhängigkeit')?->format('Y-m-d'))->toBe('2024-06-23');
});

it('includes catholic holidays that were previously missing', function () {
    // Appenzell Innerrhoden is a catholic canton observing Assumption, All Saints and Immaculate Conception.
    $appenzell = Holidays::for(Switzerland::make('ch-ai'), year: 2024)->get();
    expect(findDate($appenzell, 'Maria Himmelfahrt')?->format('Y-m-d'))->toBe('2024-08-15')
        ->and(findDate($appenzell, 'Allerheiligen')?->format('Y-m-d'))->toBe('2024-11-01')
        ->and(findDate($appenzell, 'Maria Empfängnis')?->format('Y-m-d'))->toBe('2024-12-08');

    // Schwyz observes Epiphany, Ticino observes Corpus Christi.
    $schwyz = Holidays::for(Switzerland::make('ch-sz'), year: 2024)->get();
    expect(findDate($schwyz, 'Heilige Drei Könige')?->format('Y-m-d'))->toBe('2024-01-06');

    $ticino = Holidays::for(Switzerland::make('ch-ti'), year: 2024)->get();
    expect(findDate($ticino, 'Fronleichnam')?->format('Y-m-d'))->toBe('2024-05-30');
});

it('does not add canton-specific holidays to other cantons', function () {
    $zurich = Holidays::for(Switzerland::make('ch-zh'), year: 2024)->get();

    expect(findDate($zurich, 'Näfelser Fahrt'))->toBeNull()
        ->and(findDate($zurich, 'Peter und Paul'))->toBeNull()
        ->and(findDate($zurich, 'Bruderklausenfest'))->toBeNull()
        ->and(findDate($zurich, 'Fest der Unabhängigkeit'))->toBeNull();
});

it('does not add substitute holidays when new year, national day or christmas fall on a sunday', function () {
    // 2023-01-01 is a Sunday; neither Geneva nor Neuchâtel observe a substitute day for it.
    $geneva = Holidays::for(Switzerland::make('ch-ge'), year: 2023)->get();
    $neuchatel = Holidays::for(Switzerland::make('ch-ne'), year: 2023)->get();
    expect(findDate($geneva, 'Neujahrs nächster tag'))->toBeNull()
        ->and(findDate($neuchatel, 'Neujahrs nächster tag'))->toBeNull();

    // 2021-08-01 is a Sunday; there is no substitute Swiss National Day.
    $geneva2021 = Holidays::for(Switzerland::make('ch-ge'), year: 2021)->get();
    expect(findDate($geneva2021, 'Bundesfeier nächster tag'))->toBeNull();

    // 2022-12-25 is a Sunday; there is no substitute Christmas Day.
    $geneva2022 = Holidays::for(Switzerland::make('ch-ge'), year: 2022)->get();
    $neuchatel2022 = Holidays::for(Switzerland::make('ch-ne'), year: 2022)->get();
    expect(findDate($geneva2022, 'Weihnachtsnächstertag'))->toBeNull()
        ->and(findDate($neuchatel2022, 'Weihnachtsnächstertag'))->toBeNull();
});

it('distinguishes reformed and catholic districts', function () {
    // Aargau's catholic districts observe the catholic holidays, but not the reformed-district ones.
    $catholic = Holidays::for(Switzerland::make('ch-ag-c'), year: 2024)->get();
    expect(findDate($catholic, 'Fronleichnam')?->format('Y-m-d'))->toBe('2024-05-30')
        ->and(findDate($catholic, 'Maria Himmelfahrt')?->format('Y-m-d'))->toBe('2024-08-15')
        ->and(findDate($catholic, 'Allerheiligen')?->format('Y-m-d'))->toBe('2024-11-01')
        ->and(findDate($catholic, 'Maria Empfängnis')?->format('Y-m-d'))->toBe('2024-12-08')
        ->and(findDate($catholic, 'Berchtoldstag'))->toBeNull()
        ->and(findDate($catholic, 'Ostermontag'))->toBeNull()
        ->and(findDate($catholic, 'Stephanstag'))->toBeNull();

    // Aargau's reformed districts observe Berchtold's Day, Easter/Whit Monday and St. Stephen's Day,
    // but not the catholic-district ones.
    $reformed = Holidays::for(Switzerland::make('ch-ag-r'), year: 2024)->get();
    expect(findDate($reformed, 'Berchtoldstag')?->format('Y-m-d'))->toBe('2024-01-02')
        ->and(findDate($reformed, 'Ostermontag')?->format('Y-m-d'))->toBe('2024-04-01')
        ->and(findDate($reformed, 'Pfingstmontag')?->format('Y-m-d'))->toBe('2024-05-20')
        ->and(findDate($reformed, 'Stephanstag')?->format('Y-m-d'))->toBe('2024-12-26')
        ->and(findDate($reformed, 'Fronleichnam'))->toBeNull()
        ->and(findDate($reformed, 'Allerheiligen'))->toBeNull();

    // The bare canton code is entire-region only: neither the catholic- nor reformed-district
    // holidays are included.
    $bare = Holidays::for(Switzerland::make('ch-ag'), year: 2024)->get();
    expect(findDate($bare, 'Fronleichnam'))->toBeNull()
        ->and(findDate($bare, 'Maria Himmelfahrt'))->toBeNull()
        ->and(findDate($bare, 'Berchtoldstag'))->toBeNull()
        ->and(findDate($bare, 'Ostermontag'))->toBeNull()
        ->and(findDate($bare, 'Karfreitag')?->format('Y-m-d'))->toBe('2024-03-29');

    // Graubünden's catholic districts additionally observe Epiphany; the bare code and reformed
    // districts do not (Graubünden has no reformed-only additions beyond the entire-region set).
    $grisonsCatholic = Holidays::for(Switzerland::make('ch-gr-c'), year: 2024)->get();
    expect(findDate($grisonsCatholic, 'Heilige Drei Könige')?->format('Y-m-d'))->toBe('2024-01-06');

    $grisonsBare = Holidays::for(Switzerland::make('ch-gr'), year: 2024)->get();
    $grisonsReformed = Holidays::for(Switzerland::make('ch-gr-r'), year: 2024)->get();
    expect(findDate($grisonsBare, 'Heilige Drei Könige'))->toBeNull()
        ->and(findDate($grisonsBare, 'Fronleichnam'))->toBeNull()
        ->and(findDate($grisonsReformed, 'Heilige Drei Könige'))->toBeNull()
        ->and(findDate($grisonsReformed, 'Fronleichnam'))->toBeNull();

    // Solothurn's bare code and reformed districts exclude Corpus Christi/Assumption/All Saints,
    // which are catholic-district-only.
    $solothurnCatholic = Holidays::for(Switzerland::make('ch-so-c'), year: 2024)->get();
    $solothurnBare = Holidays::for(Switzerland::make('ch-so'), year: 2024)->get();
    expect(findDate($solothurnCatholic, 'Fronleichnam')?->format('Y-m-d'))->toBe('2024-05-30')
        ->and(findDate($solothurnBare, 'Fronleichnam'))->toBeNull()
        ->and(findDate($solothurnBare, 'Allerheiligen'))->toBeNull();
});

it('only observes Berchtold and the Näfels Ride in Glarus, not the marian feasts', function () {
    $glarus = Holidays::for(Switzerland::make('ch-gl'), year: 2024)->get();

    expect(findDate($glarus, 'Berchtoldstag')?->format('Y-m-d'))->toBe('2024-01-02')
        ->and(findDate($glarus, 'Näfelser Fahrt')?->format('Y-m-d'))->toBe('2024-04-04')
        ->and(findDate($glarus, 'Maria Empfängnis'))->toBeNull()
        ->and(findDate($glarus, 'Allerheiligen'))->toBeNull();
});

it('translates the new swiss holidays', function () {
    $ticino = Holidays::for(Switzerland::make('ch-ti'), year: 2024, locale: 'it')->get();
    expect(findDate($ticino, 'Santi Pietro e Paolo')?->format('Y-m-d'))->toBe('2024-06-29');

    $jura = Holidays::for(Switzerland::make('ch-ju'), year: 2024, locale: 'fr')->get();
    expect(findDate($jura, "Fête de l'indépendance jurassienne")?->format('Y-m-d'))->toBe('2024-06-23');
});

it('throws an error when an invalid region is given', function () {
    new Switzerland('ch-xx');
})->throws(InvalidRegion::class);

it('can translate swiss holidays into french', function () {
    $holidays = Holidays::for(country: 'ch', locale: 'fr', year: 2024)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});

it('can translate swiss holidays into italian', function () {
    $holidays = Holidays::for(country: 'ch', locale: 'it', year: 2024)->get();

    expect($holidays)
        ->toBeArray()
        ->not()->toBeEmpty();

    expect(formatDates($holidays))->toMatchSnapshot();
});
