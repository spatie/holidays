<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Contracts\Islamic;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\HolidayType;

class SaudiArabia extends Country implements Islamic
{
    use IslamicCalendar;

    /**
     * Per Article 24 of the Implementing Regulations of the Saudi Labor Law, the four-day Eid al-Fitr
     * holiday starts the day after 29 Ramadan (Umm al-Qura), so it includes 30 Ramadan in long months.
     * https://web.archive.org/web/20240610223551/http://laboreducation.hrsd.gov.sa/en/labor-education/322
     */
    protected function eidAlFitrDates(): array
    {
        return [
            2020 => '05-23',
            2021 => '05-12',
            2022 => '05-01',
            2023 => '04-21',
            2024 => '04-09',
            2025 => '03-30',
            2026 => '03-19',
            2027 => '03-09',
            2028 => '02-26',
            2029 => '02-14',
            2030 => '02-03',
            2031 => '01-24',
            2032 => '01-14',
            2033 => ['01-02', '12-22'],
            2034 => '12-11',
            2035 => '11-30',
            2036 => '11-19',
            2037 => '11-08',
        ];
    }

    /** @return array<int, string> */
    protected function arafatDates(): array
    {
        return [
            2020 => '07-30',
            2021 => '07-19',
            2022 => '07-08',
            2023 => '06-27',
            2024 => '06-15',
            2025 => '06-05',
            2026 => '05-26',
            2027 => '05-15',
            2028 => '05-04',
            2029 => '04-23',
            2030 => '04-12',
            2031 => '04-01',
            2032 => '03-21',
            2033 => '03-11',
            2034 => '02-28',
            2035 => '02-18',
            2036 => '02-07',
            2037 => '01-26',
        ];
    }

    protected function eidAlAdhaDates(): array
    {
        return [
            2020 => '07-31',
            2021 => '07-20',
            2022 => '07-09',
            2023 => '06-28',
            2024 => '06-16',
            2025 => '06-06',
            2026 => '05-27',
            2027 => '05-16',
            2028 => '05-05',
            2029 => '04-24',
            2030 => '04-13',
            2031 => '04-02',
            2032 => '03-22',
            2033 => '03-12',
            2034 => '03-01',
            2035 => '02-19',
            2036 => '02-08',
            2037 => '01-27',
        ];
    }

    public function countryCode(): string
    {
        return 'sa';
    }

    protected function supportedYearRange(): array
    {
        return [2020, 2037];
    }

    protected function allHolidays(int $year): array
    {
        $newHolidays = [];

        if ($year >= 2022) {
            $newHolidays[] = Holiday::national('Founding Day', "{$year}-02-22");
        }

        return array_merge([
            Holiday::national('National Day', "{$year}-09-23"),
        ], $newHolidays, $this->islamicHolidays($year));
    }

    /** @return array<Holiday> */
    public function islamicHolidays(int $year): array
    {
        $holidays = [
            Holiday::religious('Arafat Day', $this->arafat($year)),
        ];

        foreach ($this->eidAlFitr($year, 4) as $period) {
            $holidays = array_merge($holidays, $this->convertPeriods('Eid al-Fitr Holiday', $year, $period, type: HolidayType::Religious));
        }

        foreach ($this->eidAlAdha($year, 3) as $period) {
            $holidays = array_merge($holidays, $this->convertPeriods('Eid al-Adha Holiday', $year, $period, type: HolidayType::Religious));
        }

        return $holidays;
    }
}
