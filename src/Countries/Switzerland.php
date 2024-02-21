<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Switzerland extends Country implements HasTranslations
{
    use Translatable;

    private const REGIONS = [
        'ch-ag',
        'ch-ar',
        'ch-ai',
        'ch-bl',
        'ch-bs',
        'ch-be',
        'ch-fr',
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

    private const NEW_YEARS_DAY = 'Neujahr';

    private const BERCHTOLDS_DAY = 'Berchtoldstag';

    private const THREE_KINGS_DAY = 'Heilige Drei Könige';

    private const SAINT_JOSEPHS_DAY = 'Josefstag';

    private const GOOD_FRIDAY = 'Karfreitag';

    private const EASTER_MONDAY = 'Ostermontag';

    private const LABOUR_DAY = 'Tag der Arbeit';

    private const ASCENSION_DAY = 'Auffahrt';

    private const WHIT_MONDAY = 'Pfingstmontag';

    private const CORPUS_CHRISTI = 'Fronleichnam';

    private const SWISS_NATIONAL_HOLIDAY = 'Bundesfeier';

    private const ASSUMPTION_DAY = 'Maria Himmelfahrt';

    private const FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER = 'Buss- und Bettag';

    private const ALL_SAINTS_DAY = 'Allerheiligen';

    private const IMMACULATE_CONCEPTION = 'Maria Empfängnis';

    private const CHRISTMAS_DAY = 'Weihnachtstag';

    private const SAINT_STEPHENS_DAY = 'Stephanstag';

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
            self::BERCHTOLDS_DAY => '01-02',
            self::THREE_KINGS_DAY => '01-06',
            self::SAINT_JOSEPHS_DAY => '03-19',
            self::GOOD_FRIDAY => $easter->subDays(2),
            self::EASTER_MONDAY => $easter->addDay(),
            self::LABOUR_DAY => '05-01',
            self::WHIT_MONDAY => $easter->addDays(50),
            self::CORPUS_CHRISTI => $easter->addDays(60),
            self::ASSUMPTION_DAY => '08-15',
            self::FEDERAL_DAY_OF_THANKSGIVING_REPENTANCE_AND_PRAYER => new CarbonImmutable('third sunday of September '.$year, 'Europe/Zurich'),
            self::ALL_SAINTS_DAY => '11-01',
            self::IMMACULATE_CONCEPTION => '12-08',
            self::SAINT_STEPHENS_DAY => '12-26',
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
            'ch-fr' => [
                self::GOOD_FRIDAY,
            ],
            'ch-ge' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
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
            fn ($key) => in_array($key, $currentRegion),
            ARRAY_FILTER_USE_KEY
        );

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
