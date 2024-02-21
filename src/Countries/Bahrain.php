<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;
use Carbon\CarbonPeriod;
use RuntimeException;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Exceptions\InvalidYear;

class Bahrain extends Country implements HasTranslations
{
    use Translatable;
    use IslamicCalendar;

    protected const eidAlFitr = [
        2020 => '05-24',
        2021 => '05-13',
        2022 => '05-02',
        2023 => '04-20',
        2024 => '04-10',
        2025 => '03-31',
        2026 => '03-21',
        2027 => '03-10',
        2028 => '02-27',
        2029 => '02-15',
        2030 => '02-04',
        2031 => '01-25',
        2032 => '01-15',
        2033 => '01-03',
        2034 => '12-13',
        2035 => '12-02',
        2036 => '11-20',
        2037 => '11-09',
    ];

    protected const ARAFAT_DAY_HOLIDAYS = [
        2020 => '07-30',
        2021 => '07-19',
        2022 => '07-09',
        2023 => '06-27',
        2024 => '06-16',
        2025 => '06-06',
        2026 => '05-26',
        2027 => '05-16',
        2028 => '05-05',
        2029 => '04-24',
        2030 => '04-13',
        2031 => '04-02',
        2032 => '03-21',
        2033 => '03-11',
        2034 => '03-01',
        2035 => '02-18',
        2036 => '02-07',
        2037 => '01-26',
    ];

    protected const EID_AL_ADHA_HOLIDAYS = [
        2020 => '07-31',
        2021 => '07-20',
        2022 => '07-09',
        2023 => '06-28',
        2024 => '06-17',
        2025 => '06-07',
        2026 => '05-27',
        2027 => '05-17',
        2028 => '05-06',
        2029 => '04-25',
        2030 => '04-14',
        2031 => '04-03',
        2032 => '03-22',
        2033 => '03-12',
        2034 => '03-02',
        2035 => '02-19',
        2036 => '02-08',
        2037 => '01-27',
    ];

    protected const ISLAMIC_NEW_YEAR_HOLIDAYS = [
        2020 => '08-20',
        2021 => '08-09',
        2022 => '07-30',
        2023 => '07-19',
        2024 => '07-08',
        2025 => '06-06',
        2026 => '06-17',
        2027 => '06-07',
        2028 => '05-26',
        2029 => '05-15',
        2030 => '05-05',
        2031 => '04-24',
        2032 => '04-12',
        2033 => '04-01',
        2034 => '03-22',
        2035 => '03-12',
        2036 => '02-29',
        2037 => '02-17',
    ];

    protected const ASHURA_HOLIDAYS = [
        2020 => '08-30',
        2021 => '08-19',
        2022 => '08-08',
        2023 => '07-28',
        2024 => '07-17',
        2025 => '07-07',
        2026 => '06-26',
        2027 => '06-15',
        2028 => '06-04',
        2029 => '05-24',
        2030 => '05-13',
        2031 => '05-02',
        2032 => '04-20',
        2033 => '04-10',
        2034 => '03-30',
        2035 => '03-19',
        2036 => '03-08',
        2037 => '02-25',
    ];

    protected const PROPHET_MUHAMMAD_BIRTHDAY_HOLIDAYS = [
        2020 => '10-29',
        2021 => '10-21',
        2022 => '10-08',
        2023 => '09-28',
        2024 => '09-16',
        2025 => '09-06',
        2026 => '08-26',
        2027 => '08-15',
        2028 => '08-04',
        2029 => '07-25',
        2030 => '07-14',
        2031 => '07-03',
        2032 => '06-21',
        2033 => '06-10',
        2034 => '05-31',
        2035 => '05-21',
        2036 => '05-09',
        2037 => '04-29',
    ];

    public function countryCode(): string
    {
        return 'bh';
    }

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        $variableHolidays = $this->variableHolidays($year);

        return array_merge([
            'New Year\'s Day' => '1-1',
            'Labour Day' => '5-1',
            'National Day' => '12-16',
            'National Day 2' => '12-17',
        ], $variableHolidays);
    }

    /**
     * @return array<string, CarbonInterface>
     */
    protected function variableHolidays(int $year): array
    {
        $holidays = [
            'Eid al-Fitr' => $this->eidAlFitr($year),
            'Eid al-Adha' => $this->eidAlAdha($year),
            'Arafat Day' => self::ARAFAT_DAY_HOLIDAYS[$year],
            'Islamic New Year' => self::ISLAMIC_NEW_YEAR_HOLIDAYS[$year],
            'Ashura' => $this->ashura($year),
            'Birthday of the Prophet Muhammad' => self::PROPHET_MUHAMMAD_BIRTHDAY_HOLIDAYS[$year],
        ];

        return $this->convertPeriods($holidays);
    }

    protected function eidAlAdha(int $year): CarbonPeriod
    {
        try {
            $date = self::EID_AL_ADHA_HOLIDAYS[$year];
        } catch (RuntimeException) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
        $end = $start->addDays(2);

        return CarbonPeriod::create($start, '1 day', $end);
    }

    protected function ashura(int $year): CarbonPeriod
    {
        try {
            $date = self::ASHURA_HOLIDAYS[$year];
        } catch (RuntimeException) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
        $end = $start->addDay();

        return CarbonPeriod::create($start, '1 day', $end);
    }
}
