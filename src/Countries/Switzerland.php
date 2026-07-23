<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

class Switzerland extends Country implements HasRegions
{
    private const array REGIONS = [
        'ch-ag',
        'ch-ag-c', // Catholic districts of Aargau
        'ch-ag-r', // Reformed districts of Aargau
        'ch-ar',
        'ch-ai',
        'ch-bl',
        'ch-bs',
        'ch-be',
        'ch-fr',
        'ch-fr-c', // Catholic districts of Fribourg
        'ch-fr-r', // Reformed districts of Fribourg
        'ch-ge',
        'ch-gl',
        'ch-gr',
        'ch-gr-c', // Catholic districts of Graubünden
        'ch-gr-r', // Reformed districts of Graubünden
        'ch-ju',
        'ch-lu',
        'ch-ne',
        'ch-nw',
        'ch-ow',
        'ch-sh',
        'ch-sz',
        'ch-so',
        'ch-so-c', // Catholic districts of Solothurn
        'ch-so-r', // Reformed districts of Solothurn
        'ch-sg',
        'ch-ti',
        'ch-tg',
        'ch-ur',
        'ch-vd',
        'ch-vs',
        'ch-zg',
        'ch-zh',
    ];

    private const string NEW_YEARS_DAY = 'Neujahr';

    private const string BERCHTOLDS_DAY = 'Berchtoldstag';

    private const string THREE_KINGS_DAY = 'Heilige Drei Könige';

    private const string NEUCHATEL_REPUBLIC_DAY = 'Neuenburger Republik tag';

    private const string SAINT_JOSEPHS_DAY = 'Josefstag';

    private const string GOOD_FRIDAY = 'Karfreitag';

    private const string EASTER_MONDAY = 'Ostermontag';

    private const string NAEFELSER_FAHRT = 'Näfelser Fahrt';

    private const string LABOUR_DAY = 'Tag der Arbeit';

    private const string ASCENSION_DAY = 'Auffahrt';

    private const string WHIT_MONDAY = 'Pfingstmontag';

    private const string CORPUS_CHRISTI = 'Fronleichnam';

    private const string JURA_INDEPENDENCE_DAY = 'Fest der Unabhängigkeit';

    private const string SAINTS_PETER_AND_PAUL = 'Peter und Paul';

    private const string SWISS_NATIONAL_HOLIDAY = 'Bundesfeier';

    private const string ASSUMPTION_DAY = 'Maria Himmelfahrt';

    private const string GENEVA_DAY_OF_FASTING = 'Genfer Fasten';

    private const string FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER_MONDAY = 'Buss- und Bettag Montag';

    private const string BRUDERKLAUSENFEST = 'Bruderklausenfest';

    private const string ALL_SAINTS_DAY = 'Allerheiligen';

    private const string IMMACULATE_CONCEPTION = 'Maria Empfängnis';

    private const string CHRISTMAS_DAY = 'Weihnachtstag';

    private const string SAINT_STEPHENS_DAY = 'Stephanstag';

    private const string GENEVA_REPUBLIC_DAY = 'Genf Republik tag';

    public function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, self::REGIONS)) {
            throw InvalidRegion::notFound($region);
        }
    }

    public static function regions(): array
    {
        return self::REGIONS;
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function countryCode(): string
    {
        return 'ch';
    }

    protected function defaultLocale(): string
    {
        return 'de';
    }

    /** @return array<Holiday> */
    public function regionalHolidays(int $year): array
    {
        if ($this->region === null) {
            return [];
        }

        $easter = $this->easter($year);

        // The Näfelser Fahrt is held on the first Thursday of April, unless that day falls
        // in Holy Week (i.e. it is Maundy Thursday), in which case it moves one week later.
        $firstThursdayOfApril = new CarbonImmutable("first thursday of April {$year}", 'Europe/Zurich');
        $naefelserFahrt = $firstThursdayOfApril->format('Y-m-d') === $easter->subDays(3)->format('Y-m-d')
            ? $firstThursdayOfApril->addDays(7)
            : $firstThursdayOfApril;

        // Holidays observed in every canton.
        $sharedHolidays = [
            Holiday::national(self::NEW_YEARS_DAY, "{$year}-01-01"),
            Holiday::national(self::ASCENSION_DAY, $easter->addDays(39)),
            Holiday::national(self::SWISS_NATIONAL_HOLIDAY, "{$year}-08-01"),
            Holiday::national(self::CHRISTMAS_DAY, "{$year}-12-25"),
        ];

        $regionallyDifferentHolidays = [
            self::BERCHTOLDS_DAY => CarbonImmutable::createFromDate($year, 1, 2),
            self::THREE_KINGS_DAY => CarbonImmutable::createFromDate($year, 1, 6),
            self::NEUCHATEL_REPUBLIC_DAY => CarbonImmutable::createFromDate($year, 3, 1),
            self::SAINT_JOSEPHS_DAY => CarbonImmutable::createFromDate($year, 3, 19),
            self::GOOD_FRIDAY => $easter->subDays(2),
            self::EASTER_MONDAY => $easter->addDay(),
            self::NAEFELSER_FAHRT => $naefelserFahrt,
            self::LABOUR_DAY => CarbonImmutable::createFromDate($year, 5, 1),
            self::WHIT_MONDAY => $easter->addDays(50),
            self::CORPUS_CHRISTI => $easter->addDays(60),
            self::JURA_INDEPENDENCE_DAY => CarbonImmutable::createFromDate($year, 6, 23),
            self::SAINTS_PETER_AND_PAUL => CarbonImmutable::createFromDate($year, 6, 29),
            self::ASSUMPTION_DAY => CarbonImmutable::createFromDate($year, 8, 15),
            self::GENEVA_DAY_OF_FASTING => new CarbonImmutable("first sunday of September {$year}", 'Europe/Zurich')->addDays(4), // Thursday after the first Sunday of September
            self::FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER_MONDAY => new CarbonImmutable("third sunday of September {$year}", 'Europe/Zurich')->addDay(),
            self::BRUDERKLAUSENFEST => CarbonImmutable::createFromDate($year, 9, 25),
            self::ALL_SAINTS_DAY => CarbonImmutable::createFromDate($year, 11, 1),
            self::IMMACULATE_CONCEPTION => CarbonImmutable::createFromDate($year, 12, 8),
            self::SAINT_STEPHENS_DAY => CarbonImmutable::createFromDate($year, 12, 26),
            self::GENEVA_REPUBLIC_DAY => CarbonImmutable::createFromDate($year, 12, 31),
        ];

        $currentRegion = match ($this->region) {
            'ch-ag' => [ // Entire-region holidays only; see ch-ag-c / ch-ag-r for district-specific ones
                self::GOOD_FRIDAY,
            ],
            'ch-ag-c' => [ // Catholic districts
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-ag-r' => [ // Reformed districts
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ar' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ai' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-bl' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-bs' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-be' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-fr' => [ // Entire-region holidays only; see ch-fr-c / ch-fr-r for district-specific ones
                self::GOOD_FRIDAY,
            ],
            'ch-fr-c' => [ // Catholic districts
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-fr-r' => [ // Reformed districts
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ge' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::GENEVA_DAY_OF_FASTING,
                self::GENEVA_REPUBLIC_DAY,
            ],
            'ch-gl' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::NAEFELSER_FAHRT,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-gr', 'ch-gr-r' => [ // Entire-region holidays (no Reformed-district-specific additions)
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-gr-c' => [ // Catholic districts
                self::THREE_KINGS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ju' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::JURA_INDEPENDENCE_DAY,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
            ],
            'ch-lu' => [
                self::BERCHTOLDS_DAY,
                self::SAINT_JOSEPHS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ne' => [
                self::BERCHTOLDS_DAY,
                self::NEUCHATEL_REPUBLIC_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
            ],
            'ch-nw' => [
                self::SAINT_JOSEPHS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ow' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::BRUDERKLAUSENFEST,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-sh' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-sz' => [
                self::THREE_KINGS_DAY,
                self::SAINT_JOSEPHS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-so', 'ch-so-r' => [ // Entire-region holidays (no Reformed-district-specific additions)
                self::GOOD_FRIDAY,
                self::LABOUR_DAY,
            ],
            'ch-so-c' => [ // Catholic districts
                self::GOOD_FRIDAY,
                self::LABOUR_DAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
            ],
            'ch-sg' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::ALL_SAINTS_DAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ti' => [
                self::THREE_KINGS_DAY,
                self::SAINT_JOSEPHS_DAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::SAINTS_PETER_AND_PAUL,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-tg' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ur' => [
                self::THREE_KINGS_DAY,
                self::SAINT_JOSEPHS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-vd' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER_MONDAY,
            ],
            'ch-vs' => [
                self::SAINT_JOSEPHS_DAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-zg' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-zh' => [
                self::BERCHTOLDS_DAY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            default => [],
        };

        $regionalHolidayData = array_filter(
            $regionallyDifferentHolidays,
            fn ($key): bool => in_array($key, $currentRegion),
            ARRAY_FILTER_USE_KEY
        );

        $regionalHolidays = [];
        foreach ($regionalHolidayData as $name => $date) {
            $regionalHolidays[] = Holiday::regional($name, $date, $this->region);
        }

        return array_merge($regionalHolidays, $sharedHolidays);
    }

    protected function allHolidays(int $year): array
    {
        if ($this->region !== null) {
            return $this->regionalHolidays($year);
        }

        return array_merge([
            Holiday::national(self::NEW_YEARS_DAY, "{$year}-01-01"),
            Holiday::national(self::BERCHTOLDS_DAY, "{$year}-01-02"),
            Holiday::national(self::SWISS_NATIONAL_HOLIDAY, "{$year}-08-01"),
            Holiday::national(self::CHRISTMAS_DAY, "{$year}-12-25"),
            Holiday::national(self::SAINT_STEPHENS_DAY, "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national(self::GOOD_FRIDAY, $easter->subDays(2)),
            Holiday::national(self::EASTER_MONDAY, $easter->addDay()),
            Holiday::national(self::ASCENSION_DAY, $easter->addDays(39)),
            Holiday::national(self::WHIT_MONDAY, $easter->addDays(50)),
        ];
    }
}
