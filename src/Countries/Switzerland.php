<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;

class Switzerland extends Country
{

    protected function __construct(
        protected ?string $region = null
    ) {
    }

    public function countryCode(): string
    {
        return 'ch';
    }

    protected function allHolidays(int $year): array
    {

        return array_merge([
            'Swiss National Day' => '08-01',
        ],
            $this->region ? $this->getRegionHolidays($year) : $this->getDefaultSwissHolidays($year),
        );
    }

    /**
     * This defaults to SBB/CFF/FFS holidays or postal holidays
     * https://github.com/spatie/holidays/pull/49/files#r1462344840
     * @return array<string, string|CarbonImmutable>
     */
    private function getDefaultSwissHolidays(int $year): array
    {

        return array_merge([
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ], $this->getEasterHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    private function getEasterHolidays(int $year, bool $with_good_friday = true, bool $with_corpus_christi = false): array
    {

        $easter = $this->easter($year);

        $easter_holidays = [
            'Easter Monday' => $easter->addDay(),
            'Ascension Day' => $easter->addDays(39),
            'Whit Monday' => $easter->addDays(50),
        ];

        if ($with_good_friday) {
            $easter_holidays['Good Friday'] = $easter->subDays(2);
        }

        if ($with_corpus_christi) {
            $easter_holidays['Corpus Christi'] = $easter->addDays(60);
        }

        return $easter_holidays;
    }

    /** @return array<string, string|CarbonImmutable> */
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

    /** @return array<string, string|CarbonImmutable> */
    private function getCantonHolidays(string $canton, int $year): array
    {
        return match ($canton) {
            'vs' => $this->getVSHolidays($year),
            default => [],
        };
    }

    /** @return array<string, string> */
    private function getVSHolidays(int $year): array
    {
        $eastern_holidays = $this->getEasterHolidays($year, with_good_friday: false, with_corpus_christi: true);

        return array_merge([
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            'St. Joseph\'s Day' => '03-19',
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ], $eastern_holidays);
    }


}
