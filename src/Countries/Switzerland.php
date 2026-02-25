<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Switzerland extends Country implements HasTranslations
{
    use Translatable;

    private const array REGIONS = [
        'ch-ag',
        'ch-ar',
        'ch-ai',
        'ch-bl',
        'ch-bs',
        'ch-be',
        'ch-fr',
        'ch-fr-c',
        'ch-fr-r',
        'ch-ge',
        'ch-gl',
        'ch-gr',
        'ch-ju',
        'ch-lu',
        'ch-ne',
        'ch-nw',
        'ch-ow',
        'ch-sh',
        'ch-sz',
        'ch-so',
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

    private const string NEW_YEARS_NEXT_DAY = 'Neujahrs nächster tag';

    private const string BERCHTOLDS_DAY = 'Berchtoldstag';

    private const string THREE_KINGS_DAY = 'Heilige Drei Könige';

    private const string NEUCHATEL_REPUBLIC_DAY = 'Neuenburger Republik tag';

    private const string SAINT_JOSEPHS_DAY = 'Josefstag';

    private const string GOOD_FRIDAY = 'Karfreitag';

    private const string EASTER_MONDAY = 'Ostermontag';

    private const string LABOUR_DAY = 'Tag der Arbeit';

    private const string ASCENSION_DAY = 'Auffahrt';

    private const string WHIT_MONDAY = 'Pfingstmontag';

    private const string CORPUS_CHRISTI = 'Fronleichnam';

    private const string SWISS_NATIONAL_HOLIDAY = 'Bundesfeier';

    private const string SWISS_NATIONAL_HOLIDAY_NEXT_DAY = 'Bundesfeier nächster tag';

    private const string ASSUMPTION_DAY = 'Maria Himmelfahrt';

    private const string GENEVA_DAY_OF_FASTING = 'Genfer Fasten';

    private const string FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER = 'Buss- und Bettag';

    private const string FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER_MONDAY = 'Buss- und Bettag Montag';

    private const string ALL_SAINTS_DAY = 'Allerheiligen';

    private const string IMMACULATE_CONCEPTION = 'Maria Empfängnis';

    private const string CHRISTMAS_DAY = 'Weihnachtstag';

    private const string CHRISTMAS_NEXT_DAY = 'Weihnachtsnächstertag';

    private const string SAINT_STEPHENS_DAY = 'Stephanstag';

    private const string GENEVA_REPUBLIC_DAY = 'Genf Republik tag';

    public function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, self::REGIONS)) {
            throw InvalidRegion::notFound($region);
        }
    }

    public function countryCode(): string
    {
        return 'ch';
    }

    public function defaultLocale(): string
    {
        return 'de';
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    public function regionalHolidays(int $year): array
    {
        if ($this->region === null) {
            return [];
        }

        $easter = $this->easter($year);

        $sharedHolidays = [
            self::NEW_YEARS_DAY => '01-01',
            self::ASCENSION_DAY => $easter->addDays(39),
            self::SWISS_NATIONAL_HOLIDAY => '08-01',
            self::CHRISTMAS_DAY => '12-25',
        ];

        $regionallyDifferentHolidays = [
            self::NEW_YEARS_NEXT_DAY => '01-02',
            self::BERCHTOLDS_DAY => '01-02',
            self::THREE_KINGS_DAY => '01-06',
            self::NEUCHATEL_REPUBLIC_DAY => '03-01',
            self::SAINT_JOSEPHS_DAY => '03-19',
            self::GOOD_FRIDAY => $easter->subDays(2),
            self::EASTER_MONDAY => $easter->addDay(),
            self::LABOUR_DAY => '05-01',
            self::WHIT_MONDAY => $easter->addDays(50),
            self::CORPUS_CHRISTI => $easter->addDays(60),
            self::SWISS_NATIONAL_HOLIDAY_NEXT_DAY => '08-02',
            self::ASSUMPTION_DAY => '08-15',
            self::GENEVA_DAY_OF_FASTING => new CarbonImmutable('first sunday of September '.$year, 'Europe/Zurich')->addDays(4), // Thursday after the first Sunday of September
            self::FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER => new CarbonImmutable('third sunday of September '.$year, 'Europe/Zurich'),
            self::FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER_MONDAY => new CarbonImmutable('third sunday of September '.$year, 'Europe/Zurich')->addDay(),
            self::ALL_SAINTS_DAY => '11-01',
            self::IMMACULATE_CONCEPTION => '12-08',
            self::SAINT_STEPHENS_DAY => '12-26',
            self::CHRISTMAS_NEXT_DAY => '12-26',
            self::GENEVA_REPUBLIC_DAY => '12-31',
        ];

        $currentRegion = match ($this->region) {
            'ch-ag' => [
                self::GOOD_FRIDAY,
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
            'ch-fr', 'ch-fr-c' => [ // Catholic part of the canton is the default
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-fr-r' => [ // Reformed part of the canton has special legislation for holidays
                self::NEW_YEARS_NEXT_DAY,
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
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-gr' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ju' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
            ],
            'ch-lu' => [
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-ne' => [
                self::NEUCHATEL_REPUBLIC_DAY,
                self::GOOD_FRIDAY,
                self::LABOUR_DAY,
            ],
            'ch-nw' => [
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-ow' => [
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-sh' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::SAINT_STEPHENS_DAY,
            ],
            'ch-sz' => [
                self::SAINT_JOSEPHS_DAY,
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
            ],
            'ch-so' => [
                self::GOOD_FRIDAY,
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
                self::EASTER_MONDAY,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
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
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-zh' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOUR_DAY,
                self::WHIT_MONDAY,
                self::FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER,
                self::SAINT_STEPHENS_DAY,
            ],
            default => [],
        };

        $regionalHolidays = array_filter(
            $regionallyDifferentHolidays,
            fn ($key): bool => in_array($key, $currentRegion),
            ARRAY_FILTER_USE_KEY
        );

        // Some holidays only happen in some years in some regions
        if (in_array($this->region, ['ch-ge', 'ch-ne']) &&
            new CarbonImmutable("{$year}-01-01", 'Europe/Zurich')->isSunday()) {
            $regionalHolidays[self::NEW_YEARS_NEXT_DAY] = '01-02';
        }

        if (in_array($this->region, ['ch-ge']) &&
            new CarbonImmutable("{$year}-08-01", 'Europe/Zurich')->isSunday()) {
            $regionalHolidays[self::SWISS_NATIONAL_HOLIDAY_NEXT_DAY] = '08-02';
        }

        if (in_array($this->region, ['ch-ge', 'ch-ne']) &&
            new CarbonImmutable("{$year}-12-25", 'Europe/Zurich')->isSunday()) {
            $regionalHolidays[self::CHRISTMAS_NEXT_DAY] = '12-26';
        }

        return array_merge($regionalHolidays, $sharedHolidays);
    }

    protected function allHolidays(int $year): array
    {
        if ($this->region !== null) {
            return $this->regionalHolidays($year);
        }

        return array_merge([
            self::NEW_YEARS_DAY => '01-01',
            self::BERCHTOLDS_DAY => '01-02',
            self::SWISS_NATIONAL_HOLIDAY => '08-01',
            self::CHRISTMAS_DAY => '12-25',
            self::SAINT_STEPHENS_DAY => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            self::GOOD_FRIDAY => $easter->subDays(2),
            self::EASTER_MONDAY => $easter->addDay(),
            self::ASCENSION_DAY => $easter->addDays(39),
            self::WHIT_MONDAY => $easter->addDays(50),
        ];
    }
}
