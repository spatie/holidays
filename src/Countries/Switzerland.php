<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Switzerland extends Country
{
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

    private const LOCALES = [
        'de',
        'fr',
        'it',
    ];

    private const NEW_YEAR = 'Neujahr';

    private const SECOND_JANUARY = 'Berchtoldstag';

    private const THREE_KINGS = 'Heilige Drei Könige';

    private const DAY_OF_JOSEPH = 'Josefstag';

    private const GOOD_FRIDAY = 'Karfreitag';

    private const EASTER_MONDAY = 'Ostermontag';

    private const LABOR_DAY = 'Tag der Arbeit';

    private const ASCENSION_DAY = 'Auffahrt';

    private const WHIT_MONDAY = 'Pfingstmontag';

    private const CORPUS_CHRISTI = 'Fronleichnam';

    private const FEDERAL_CELEBRATION = 'Bundesfeier';

    private const ASSUMPTION_DAY = 'Maria Himmelfahrt';

    private const ALL_SAINTS_DAY = 'Allerheiligen';

    private const IMMACULATE_CONCEPTION = 'Maria Empfängnis';

    private const CHRISTMAS_DAY = 'Weihnachtstag';

    private const ST_STEPHENS_DAY = 'Stephanstag';

    public function __construct(protected ?string $region = null, protected ?string $locale = null)
    {
        if ($region !== null && !in_array($region, self::REGIONS)) {
            throw InvalidRegion::unsupportedRegion($region);
        }

        if($locale !== null && !in_array($locale, self::LOCALES)) {
            throw InvalidRegion::unsupportedLocale($locale);
        }
    }

    public function countryCode(): string
    {
        return 'ch';
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
            self::NEW_YEAR => '01-01',
            self::ASCENSION_DAY => $easter->addDays(39),
            self::FEDERAL_CELEBRATION => '08-01',
            self::CHRISTMAS_DAY => '12-25',
        ];

        $regionallyDifferentHolidays = [
            self::SECOND_JANUARY => '01-02',
            self::THREE_KINGS => '01-06',
            self::DAY_OF_JOSEPH => '03-19',
            self::GOOD_FRIDAY => $easter->subDays(2),
            self::EASTER_MONDAY => $easter->addDay(),
            self::LABOR_DAY => '05-01',
            self::WHIT_MONDAY => $easter->addDays(50),
            self::CORPUS_CHRISTI => $easter->addDays(60),
            self::ASSUMPTION_DAY => '08-15',
            self::ALL_SAINTS_DAY => '11-01',
            self::IMMACULATE_CONCEPTION => '12-08',
            self::ST_STEPHENS_DAY => '12-26',
        ];

        $regions = [
            'ch-ag' => [
                self::GOOD_FRIDAY,
            ],
            'ch-ar' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::ST_STEPHENS_DAY,
            ],
            'ch-ai' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
                self::ST_STEPHENS_DAY,
            ],
            'ch-bl' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOR_DAY,
                self::WHIT_MONDAY,
                self::ST_STEPHENS_DAY,
            ],
            'ch-bs' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOR_DAY,
                self::WHIT_MONDAY,
                self::ST_STEPHENS_DAY,
            ],
            'ch-be' => [
                self::SECOND_JANUARY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::ST_STEPHENS_DAY,
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
                self::ST_STEPHENS_DAY,
            ],
            'ch-ju' => [
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::LABOR_DAY,
                self::WHIT_MONDAY,
                self::CORPUS_CHRISTI,
            ],
            'ch-lu' => [
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::ST_STEPHENS_DAY,
            ],
            'ch-ne' => [
                self::GOOD_FRIDAY,
                self::LABOR_DAY,
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
                self::ST_STEPHENS_DAY,
            ],
            'ch-sz' => [
                self::DAY_OF_JOSEPH,
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
                self::ST_STEPHENS_DAY,
            ],
            'ch-ti' => [
                self::THREE_KINGS,
                self::EASTER_MONDAY,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::ST_STEPHENS_DAY,
            ],
            'ch-tg' => [
                self::SECOND_JANUARY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
                self::ST_STEPHENS_DAY,
            ],
            'ch-ur' => [
                self::GOOD_FRIDAY,
                self::CORPUS_CHRISTI,
                self::ASSUMPTION_DAY,
                self::ALL_SAINTS_DAY,
                self::IMMACULATE_CONCEPTION,
            ],
            'ch-vd' => [
                self::SECOND_JANUARY,
                self::GOOD_FRIDAY,
                self::EASTER_MONDAY,
                self::WHIT_MONDAY,
            ],
            'ch-vs' => [
                self::DAY_OF_JOSEPH,
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
                self::LABOR_DAY,
                self::WHIT_MONDAY,
                self::ST_STEPHENS_DAY,
            ],
        ];

        $currentRegion = $regions[$this->region];

        $regionalHolidays = array_filter(
            $regionallyDifferentHolidays,
            fn ($key) => in_array($key, $currentRegion),
            ARRAY_FILTER_USE_KEY
        );

        return array_merge($regionalHolidays, $sharedHolidays);
    }

    /**
     * @param array<string, CarbonImmutable|string> $holidays
     * @return array<string, CarbonImmutable|string>
     */
    protected function translateHolidays(array $holidays): array
    {
        if ($this->locale === null) {
            return $holidays;
        }

        $translatedHolidays = [];

        foreach ($holidays as $name => $date) {
            /** @var string $translatedName */
            $translatedName = $this->translate($name);
            $translatedHolidays[$translatedName] = $date;
        }

        return $translatedHolidays;
    }

    protected function translate(string $name): string
    {
        $translations = [
            'de' => [
                self::NEW_YEAR => 'Neujahr',
                self::SECOND_JANUARY => 'Berchtoldstag',
                self::THREE_KINGS => 'Heilige Drei Könige',
                self::DAY_OF_JOSEPH => 'Josefstag',
                self::GOOD_FRIDAY => 'Karfreitag',
                self::EASTER_MONDAY => 'Ostermontag',
                self::LABOR_DAY => 'Tag der Arbeit',
                self::ASCENSION_DAY => 'Auffahrt',
                self::WHIT_MONDAY => 'Pfingstmontag',
                self::CORPUS_CHRISTI => 'Fronleichnam',
                self::FEDERAL_CELEBRATION => 'Bundesfeier',
                self::ASSUMPTION_DAY => 'Maria Himmelfahrt',
                self::ALL_SAINTS_DAY => 'Allerheiligen',
                self::IMMACULATE_CONCEPTION => 'Maria Empfängnis',
                self::CHRISTMAS_DAY => 'Weihnachtstag',
                self::ST_STEPHENS_DAY => 'Stephanstag',
            ],
            'fr' => [
                self::NEW_YEAR => 'Nouvel An',
                self::SECOND_JANUARY => 'Saint-Berthold',
                self::THREE_KINGS => 'Épiphanie',
                self::DAY_OF_JOSEPH => 'Saint-Joseph',
                self::GOOD_FRIDAY => 'Vendredi saint',
                self::EASTER_MONDAY => 'Lundi de Pâques',
                self::LABOR_DAY => 'Fête du travail',
                self::ASCENSION_DAY => 'Ascension',
                self::WHIT_MONDAY => 'Lundi de Pentecôte',
                self::CORPUS_CHRISTI => 'Fête-Dieu',
                self::FEDERAL_CELEBRATION => 'Fête nationale',
                self::ASSUMPTION_DAY => 'Assomption',
                self::ALL_SAINTS_DAY => 'Toussaint',
                self::IMMACULATE_CONCEPTION => 'Immaculée Conception',
                self::CHRISTMAS_DAY => 'Noël',
                self::ST_STEPHENS_DAY => 'Saint-Étienne',
            ],
            'it' => [
                self::NEW_YEAR => 'Capodanno',
                self::SECOND_JANUARY => 'San Silvestro',
                self::THREE_KINGS => 'Epifania',
                self::DAY_OF_JOSEPH => 'San Giuseppe',
                self::GOOD_FRIDAY => 'Venerdì Santo',
                self::EASTER_MONDAY => 'Lunedì di Pasqua',
                self::LABOR_DAY => 'Festa del lavoro',
                self::ASCENSION_DAY => 'Ascensione',
                self::WHIT_MONDAY => 'Lunedì di Pentecoste',
                self::CORPUS_CHRISTI => 'Corpus Domini',
                self::FEDERAL_CELEBRATION => 'Festa nazionale',
                self::ASSUMPTION_DAY => 'Assunzione',
                self::ALL_SAINTS_DAY => 'Ognissanti',
                self::IMMACULATE_CONCEPTION => 'Immacolata Concezione',
                self::CHRISTMAS_DAY => 'Natale',
                self::ST_STEPHENS_DAY => 'Santo Stefano',
            ],
        ];

        return $translations[$this->locale][$name];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function translatedHolidays(int $year): array
    {
        return $this->translateHolidays($this->untranslatedHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function untranslatedHolidays(int $year): array
    {
        if($this->region !== null) {
            return $this->regionalHolidays($year);
        }

        return array_merge([
            self::NEW_YEAR => '01-01',
            self::SECOND_JANUARY => '01-02',
            self::FEDERAL_CELEBRATION => '08-01',
            self::CHRISTMAS_DAY => '12-25',
            self::ST_STEPHENS_DAY => '12-26',
        ], $this->variableHolidays($year));
    }

    protected function allHolidays(int $year): array
    {
        return $this->locale !== null
            ? $this->translatedHolidays($year)
            : $this->untranslatedHolidays($year);
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
