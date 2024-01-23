<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Switzerland extends Country
{
    const HOLIDAYS = [
        'New Year\'s Day' => ['de' => 'Neujahrstag', 'fr' => 'Nouvel an', 'it' => 'Capodanno', 'rm' => 'Bun di bun onn'],
        'Berchtold Day' => ['de' => 'Berchtoldstag', 'fr' => '2 janvier', 'it' => 'Giorno di Berchtold', 'rm' => 'Di da Berchtold'],
        'St. Joseph\'s Day' => ['de' => 'Josefstag', 'fr' => 'Saint-Joseph', 'it' => 'Giorno di San Giuseppe', 'rm' => 'Di da San Giusep'],
        'Good Friday' => ['de' => 'Karfreitag', 'fr' => 'Vendredi saint', 'it' => 'Venerdì santo', 'rm' => 'Venderdi santo'],
        'Easter Monday' => ['de' => 'Ostermontag', 'fr' => 'Lundi de Pâques', 'it' => 'Lunedì di Pasqua', 'rm' => 'Glindesdi da Pasca'],
        'Ascension Day' => ['de' => 'Auffahrt', 'fr' => 'Ascension', 'it' => 'Ascensione', 'rm' => 'Ascensiun'],
        'Whit Monday' => ['de' => 'Pfingstmontag', 'fr' => 'Lundi de Pentecôte', 'it' => 'Lunedì di Pentecoste', 'rm' => 'Glindesdi da Pentecosta'],
        'Corpus Christi' => ['de' => 'Fronleichnam', 'fr' => 'Fête-Dieu', 'it' => 'Corpus Domini', 'rm' => 'Corpus Christi'],
        'Swiss National Day' => ['de' => 'Bundesfeier', 'fr' => 'Fête nationale', 'it' => 'Festa nazionale', 'rm' => 'Fiasta naziunala'],
        'Assumption Day' => ['de' => 'Maria Himmelfahrt', 'fr' => 'Assomption', 'it' => 'Assunzione', 'rm' => 'Assunta'],
        'All Saints\' Day' => ['de' => 'Allerheiligen', 'fr' => 'Toussaint', 'it' => 'Ognissanti', 'rm' => 'Ognissants'],
        'Immaculate Conception' => ['de' => 'Maria Empfängnis', 'fr' => 'Immaculée Conception', 'it' => 'Immacolata Concezione', 'rm' => 'Concepziun da Maria'],
        'Christmas Day' => ['de' => 'Weihnachtstag', 'fr' => 'Noël', 'it' => 'Natale', 'rm' => 'Nadal'],
        'St. Stephen\'s Day' => ['de' => 'Stephanstag', 'fr' => 'Saint-Étienne', 'it' => 'Santo Stefano', 'rm' => 'San Steffan'],
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
            $this->trans('Swiss National Day')=> '08-01',
        ],
            $this->region ? $this->getRegionHolidays($year) : $this->getSwissHolidays($year),
        );
    }

    /**
     * This defaults to SBB/CFF/FFS holidays or postal holidays
     * https://github.com/spatie/holidays/pull/49/files#r1462344840
     * @return array<string, CarbonImmutable>
     */
    private function getSwissHolidays(int $year): array
    {

        return array_merge([
            $this->trans('New Year\'s Day') => '01-01',
            $this->trans('Berchtold Day') => '01-02',
            $this->trans('Christmas Day') => '12-25',
            $this->trans('St. Stephen\'s Day') => '12-26',
        ], $this->getEasterHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    private function getEasterHolidays(int $year, bool $with_good_friday = true, bool $with_corpus_christi = false): array
    {

        $easter = $this->easter($year);

        $easter_holidays = [
            $this->trans('Easter Monday') => $easter->addDay(),
            $this->trans('Ascension Day') => $easter->addDays(39),
            $this->trans('Whit Monday') => $easter->addDays(50),
        ];

        if ($with_good_friday) {
            $easter_holidays[$this->trans('Good Friday')] = $easter->subDays(2);
        }

        if ($with_corpus_christi) {
            $easter_holidays[$this->trans('Corpus Christi')] = $easter->addDays(60);
        }

        return $easter_holidays;
    }

    /** @return array<string, CarbonImmutable> */
    private function getRegionHolidays(int $year): array
    {

        if (!$this->region) {
            return [];
        }

        // split region into canton and region
        $region = explode('-', $this->region);
        $canton = $region[1];

        // get holidays for canton
        return $this->getCantonHolidays($canton, $year);
    }

    private function getCantonHolidays(string $canton, int $year): array
    {
        return match ($canton) {
            'vs' => $this->getVSHolidays($year),
            default => [],
        };
    }

    private function trans(string $key): string
    {

        // return translation if available
        if (isset(self::HOLIDAYS[$key][$this->locale])) {
            return self::HOLIDAYS[$key][$this->locale];
        }

        // return key if no translation is available
        return $key;
    }

    /** @return array<string, string> */
    private function getVSHolidays(int $year): array
    {
        $eastern_holidays = $this->getEasterHolidays($year, with_good_friday: false, with_corpus_christi: true);

        return array_merge([
            $this->trans('New Year\'s Day') => '01-01',
            $this->trans('Berchtold Day') => '01-02',
            $this->trans('St. Joseph\'s Day') => '03-19', // St. Joseph
            $this->trans('Assumption Day') => '08-15', // Assumption
            $this->trans('All Saints\' Day') => '11-01', // All Saints
            $this->trans('Immaculate Conception') => '12-08', // Immaculate Conception
            $this->trans('Christmas Day') => '12-25',
            $this->trans('St. Stephen\'s Day') => '12-26',
        ], $eastern_holidays);
    }


}
