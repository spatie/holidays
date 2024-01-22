<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Switzerland extends Country
{
    const HOLIDAYS_DE = [
        '01-01' => 'Neujahrstag',
        '01-02' => 'Berchtoldstag',
        '03-19' => 'Josefstag',
        '= easter -2' => 'Karfreitag',
        '= easter' => 'Ostermontag',
        '= easter 39' => 'Auffahrt',
        '= easter 50' => 'Pfingstmontag',
        '= easter 60' => 'Fronleichnam',
        '08-01' => 'Bundesfeier',
        '08-15' => 'Maria Himmelfahrt',
        '11-01' => 'Allerheiligen',
        '12-08' => 'Maria Empfängnis',
        '12-25' => 'Weihnachtstag',
        '12-26' => 'Stephanstag',
    ];

    const HOLIDAYS_FR = [
        '01-01' => 'Nouvel an',
        '01-02' => 'Saint-Etienne',
        '03-19' => 'Saint-Joseph',
        '= easter -2' => 'Vendredi Saint',
        '= easter' => 'Lundi de Pâques',
        '= easter 39' => 'Ascension',
        '= easter 50' => 'Lundi de Pentecôte',
        '= easter 60' => 'Fête-Dieu',
        '08-01' => 'Fête nationale',
        '08-15' => 'Assomption',
        '11-01' => 'Toussaint',
        '12-25' => 'Noël',
        '12-26' => 'Saint Etienne',
    ];

    const HOLIDAYS_IT = [
        '01-01' => 'Capodanno',
        '01-02' => 'San Berchtoldo',
        '= easter -2' => 'Venerdì Santo', // This does not seem to be a holiday in Ticino
        '= easter' => 'Lunedì di Pasqua',
        '= easter 39' => 'Ascensione',
        '= easter 50' => 'Lunedì di Pentecoste',
        '08-01' => 'Festa nazionale',
        '12-25' => 'Natale',
        '12-26' => 'Santo Stefano',
    ];

    protected function __construct(
        protected ?string $region = null,
        protected string $locale = 'de',
    ) {
    }

    public function countryCode(): string
    {
        return 'ch';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            $this->getLocaleHoliday('08-01')=> '08-01',
        ],
            $this->region ? $this->getSwissHolidays($year) : $this->getRegionHolidays($year),
        );
    }

    // This defaults to SBB/CFF/FFS holidays or postal holidays
    // https://github.com/spatie/holidays/pull/49/files#r1462344840
    private function getSwissHolidays(int $year): array
    {

        $easter = $this->easter($year);

        return array_merge([
            $this->getLocaleHoliday('01-01') => '01-01',
            $this->getLocaleHoliday('01-02') => '01-02',
            $this->getLocaleHoliday('25-12') => '12-25',
            $this->getLocaleHoliday('26-12') => '12-26',
        ], $this->getEasterHolidays($year));
    }

    private function getEasterHolidays(int $year, bool $with_easter_minus_two = true, bool $add_corpus_christi = false): array
    {

        $easter = $this->easter($year);

        $easter_holidays = [
            $this->getLocaleHoliday('= easter') => $easter->addDay(),
            $this->getLocaleHoliday('= easter 39') => $easter->addDays(39),
            $this->getLocaleHoliday('= easter 50') => $easter->addDays(50),
        ];

        if ($with_easter_minus_two) {
            $easter_holidays[$this->getLocaleHoliday('= easter -2')] = $easter->subDays(2);
        }

        if ($add_corpus_christi) {
            $easter_holidays[$this->getLocaleHoliday('= easter 60')] = $easter->addDays(60);
        }

        return $easter_holidays;
    }

    private function getRegionHolidays(int $year): array
    {

        // split region into canton and region
        $region = explode('-', $this->region);
        $canton = $region[0];
        $region = $region[1];

        // get holidays for canton
        $holidays = $this->getCantonHolidays($canton, $year);

        // if region is set, get holidays for region
        if ($region) {
            $holidays = array_merge($holidays, $this->getRegionHolidays($region, $year));
        }

        return $holidays;
    }

    private function getCantonHolidays(string $canton, int $year): array
    {
        return match ($canton) {
            'vs' => $this->getVSHolidays($year),
            default => [],
        };
    }

    private function getLocaleHoliday(string $string): string
    {
        return match ($this->locale) {
            'de' => self::HOLIDAYS_DE[$string],
            'fr' => self::HOLIDAYS_FR[$string],
            'it' => self::HOLIDAYS_IT[$string],
        };
    }

    private function getVSHolidays(int $year)
    {
        $eastern_holidays = $this->getEasterHolidays($year, with_easter_minus_two: false, add_corpus_christi: true);

        return array_merge([
            $this->getLocaleHoliday('01-01') => '01-01',
            $this->getLocaleHoliday('01-02') => '01-02',
            $this->getLocaleHoliday('03-19') => '03-19', // St. Joseph
            $this->getLocaleHoliday('08-15') => '08-15', // Assumption
            $this->getLocaleHoliday('11-01') => '11-01', // All Saints
            $this->getLocaleHoliday('12-08') => '12-08', // Immaculate Conception
            $this->getLocaleHoliday('25-12') => '12-25',
            $this->getLocaleHoliday('26-12') => '12-26',
        ], $eastern_holidays);
    }


}
