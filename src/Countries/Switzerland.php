<?php

namespace Spatie\Holidays\Countries;

use _PHPStan_3d4486d07\Nette\Neon\Exception;
use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Switzerland extends Country
{


    public function __construct(
        protected ?string $region = null
    )
    {
    }

    public function countryCode(): string
    {
        return 'ch';
    }

    protected function allHolidays(int $year): array
    {

        $holidays =  array_merge([
            'Swiss National Day' => '08-01',
        ],
            $this->getCatonalHolidays($year),
        );

        return $this->normalizeHolidayArray($holidays);
    }

    /**
     * This defaults to SBB/CFF/FFS holidays or postal holidays
     * https://github.com/spatie/holidays/pull/49/files#r1462344840
     * @return non-empty-array<int|string, array<string, string>|string>
     */
    private function getDefaultSwissHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<string, string> */
    private function getVariableHoliday(int $year, string $holiday) : array
    {
        $easter = $this->easter($year);

        $value = match ($holiday) {
            'Good Friday'  => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
            'Ascension Day' => $easter->addDays(39),
            'Whit Monday' => $easter->addDays(50),
            'Corpus Christi' => $easter->addDays(60),
            default => throw new InvalidRegion('Variable holiday not supported'),
        };

        return [$holiday => $value];

    }

    /**
     * @param non-empty-array<int|string, array<string, string>|string> $holidays
     * @return array<string, string>
     */
    private function normalizeHolidayArray(array $holidays) : array
    {

        $normalized_holidays = [];

        foreach ($holidays as $key => $value) {
            if(is_array($value)) {

                foreach ($value as $sub_key => $sub_value) {
                    $normalized_holidays[$sub_key] = $sub_value;

                }
                continue;
            }

            if(is_string($key)) {
                $normalized_holidays[$key] = $value;
            }
        }

        return $normalized_holidays;
    }

    /** @return array<string, string>
     * @throws Exception
     */
    private function getCatonalHolidays(int $year): array
    {

        if($this->region === null) {
            $default_holidays = $this->getDefaultSwissHolidays($year);
            return $this->normalizeHolidayArray($default_holidays);
        }

        $canton = explode('-', $this->region)[1];

        $holidays = match ($canton) {
            'ag' => $this->getAGHolidays($year),
            'ar' => $this->getARHolidays($year),
            'ai' => $this->getAIHolidays($year),
            'bl' => $this->getBLHolidays($year),
            'bs' => $this->getBSHolidays($year),
            'be' => $this->getBEHolidays($year),
            'fr' => $this->getFRHolidays($year),
            'ge' => $this->getGEHolidays($year),
            'gl' => $this->getGLHolidays($year),
            'gr' => $this->getGRHolidays($year),
            'ju' => $this->getJUHolidays($year),
            'lu' => $this->getLUHolidays($year),
            'ne' => $this->getNEHolidays($year),
            'nw' => $this->getNWHolidays($year),
            'ow' => $this->getOWHolidays($year),
            'sh' => $this->getSHHolidays($year),
            'sz' => $this->getSZHolidays($year),
            'so' => $this->getSOHolidays($year),
            'sg' => $this->getSGHolidays($year),
            'ti' => $this->getTIHolidays($year),
            'tg' => $this->getTGHolidays($year),
            'ur' => $this->getURHolidays($year),
            'vd' => $this->getVDHolidays($year),
            'vs' => $this->getVSHolidays($year),
            'zg' => $this->getZGHolidays($year),
            'zh' => $this->getZHHolidays($year),
            default => throw new InvalidRegion('Canton not supported'),
        };

        return $this->normalizeHolidayArray($holidays);
    }

    /**
     * @throws Exception
     */
    private function createCarbonImmutable(int $year, int $month, int $day): CarbonImmutable
    {
        $carbon_immutable = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$month}-{$day}");

        // check if the date is valid
        if(!$carbon_immutable) {
            throw new Exception('Invalid date');
        }

        return $carbon_immutable;
    }

    /** @return non-empty-array<int|string, string|array<string, string> > */
    private function getAGHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getARHolidays(int $year): array
    {
        // check if Christmas day is on a monday or friday
        $christmas_day = $this->createCarbonImmutable($year, 12, 25);
        $christmas_day_is_monday_or_friday = in_array($christmas_day->dayOfWeek, [1, 5]);

        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
        ],
            $christmas_day_is_monday_or_friday ? [] : ['St. Stephen\'s Day' => '12-26']
        );

    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getAIHolidays(int $year): array
    {
        // check if Christmas day is on a monday or friday
        $christmas_day = $this->createCarbonImmutable($year, 12, 25);
        $christmas_day_is_monday_or_friday = in_array($christmas_day->dayOfWeek, [1, 5]);

        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'Mauritiustag' => '09-22',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
        ],
            $christmas_day_is_monday_or_friday ? [] : ['St. Stephen\'s Day' => '12-26']
        );
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getBLHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getBSHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getBEHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /**
     * except some municipalities in the "Bezirk See / district du Lac" do not share these holidays.
     * These holidays are only valid for the canton however, not for these municipalities.
     * @return non-empty-array<int|string, array<string, string>|string>
     */
    private function getFRHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',

        ], [
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'St. Stephen\'s Day' => '12-26',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getGEHolidays(int $year): array
    {
        // get the first day of september
        $first_september = $this->createCarbonImmutable($year, 9, 1);

        // check if first september is a sunday
        $first_september_is_sunday = $first_september->dayOfWeek === 0;

        // get first sunday of september
        $first_sunday_of_september = $first_september_is_sunday ? $first_september : $first_september->next('sunday');

        // get the following thursday
        $jeune_genevois = $first_sunday_of_september->next('thursday');

        return [
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Jeûne genevois' => $jeune_genevois,
            'Christmas Day' => '12-25',
            'Restauration de la République' => '12-31',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getGLHolidays(int $year): array
    {
        // get the first day of april
        $first_april = $this->createCarbonImmutable($year, 4, 1);

        // check if first april is a thursday
        $first_april_is_thursday = $first_april->dayOfWeek === 4;

        // get first thursday of april
        $first_thursday_of_april = $first_april_is_thursday ? $first_april : $first_april->next('thursday');

        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Fahrtsfest' => $first_thursday_of_april,
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'All Saints\' Day' => '11-01',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getGRHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getJUHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Commémoration du plébiscite jurassien' => '06-23',
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Christmas Day' => '12-25',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getLUHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getNEHolidays(int $year): array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            'Establishment of the republic' => '03-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
            'Labour Day' => '05-01',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getNWHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Joseph\'s Day' => '03-19',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
        ], [
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'St. Stephen\'s Day' => '12-26',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getOWHolidays(int $year) : array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'St. Joseph\'s Day' => '03-19',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
        ], [
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'St. Stephen\'s Day' => '12-26',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getSHHolidays(int $year) : array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ], [
            'Berchtold\'s Day' => '01-02',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getSZHolidays(int $year) : array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Dreikönigstag' => '01-06',
            'St. Joseph\'s Day' => '03-19',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getSOHolidays(int $year) : array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Christmas Day' => '12-25',
        ], [
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'St. Stephen\'s Day' => '12-26',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getSGHolidays(int $year) : array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'All Saints\' Day' => '11-01',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ], [
            'Berchtold\'s Day' => '01-02',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getTIHolidays(int $year) : array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Epifania' => '01-06',
            'St. Joseph\'s Day' => '03-19',
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'San Pietro e Paolo' => '06-29',
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getTGHolidays(int $year) : array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getURHolidays(int $year) : array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Dreikönigstag' => '01-06',
            'St. Joseph\'s Day' => '03-19',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getVDHolidays(int $year) : array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
        ];
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getVSHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'St. Joseph\'s Day' => '03-19',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
        ], [
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'St. Stephen\'s Day' => '12-26',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getZGHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Corpus Christi'),
            'Assumption Day' => '08-15',
            'All Saints\' Day' => '11-01',
            'Immaculate Conception' => '12-08',
            'Christmas Day' => '12-25',
        ], [
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Easter Monday'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'St. Stephen\'s Day' => '12-26',
        ]);
    }

    /** @return non-empty-array<int|string, array<string, string>|string > */
    private function getZHHolidays(int $year) : array
    {
        return [
            'New Year\'s Day' => '01-01',
            'Berchtold\'s Day' => '01-02',
            $this->getVariableHoliday($year, 'Good Friday'),
            $this->getVariableHoliday($year, 'Easter Monday'),
            'Labour Day' => '05-01',
            $this->getVariableHoliday($year, 'Ascension Day'),
            $this->getVariableHoliday($year, 'Whit Monday'),
            'Christmas Day' => '12-25',
            'St. Stephen\'s Day' => '12-26',
        ];
    }
}
