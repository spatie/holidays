<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use RuntimeException;

class Turkey extends Country
{
    /**
     * No library or built-in php intl functions convert dates properly for all years or all country including
     * “geniusts/hijri-dates”. It is most logical to prepare the dates between 1970 and 2037 as a constant property
     * for Islamic holidays. Because Islamic holidays predicted and actual dates may change until the last moment.
     * Since the information on wikipedia is incorrect, it was obtained by searching the old calendar
     * on Google Images for each year. The accuracy of the information has been double-checked.
     * Ramadan and Sacrifice holidays vary for Turkey and other countries.
     * A converter algorithm that will cover all years does not seem possible.
     */
    public const ramadanHolidays = [
        1970 => '12-01',
        1971 => '11-20',
        1972 => '11-08',
        1973 => '10-28',
        1974 => '10-17',
        1975 => '10-06',
        1976 => '09-25',
        1977 => '09-15',
        1978 => '09-04',
        1979 => '08-24',
        1980 => '08-12',
        1981 => '08-01',
        1982 => '07-22',
        1983 => '07-12',
        1984 => '06-30',
        1985 => '06-20',
        1986 => '06-09',
        1987 => '05-29',
        1988 => '05-17',
        1989 => '05-06',
        1990 => '04-26',
        1991 => '04-16',
        1992 => '04-04',
        1993 => '03-24',
        1994 => '03-13',
        1995 => '03-03',
        1996 => '02-20',
        1997 => '02-09',
        1998 => '01-29',
        1999 => '01-19',
        2000 => [
            '01-08',
            '12-27',
        ],
        2001 => '12-16',
        2002 => '12-05',
        2003 => '11-25',
        2004 => '11-14',
        2005 => '11-03',
        2006 => '10-23',
        2007 => '10-12',
        2008 => '09-30',
        2009 => '09-20',
        2010 => '09-09',
        2011 => '08-30',
        2012 => '08-19',
        2013 => '08-08',
        2014 => '07-28',
        2015 => '07-17',
        2016 => '07-05',
        2017 => '06-25',
        2018 => '06-15',
        2019 => '06-04',
        2020 => '05-24',
        2021 => '05-13',
        2022 => '05-02',
        2023 => '04-21',
        2024 => '04-10',
        2025 => '04-30',
        2026 => '03-20',
        2027 => '03-09',
        2028 => '02-26',
        2029 => '02-14',
        2030 => '02-03',
        2031 => '01-24',
        2032 => '01-14',
        2033 => [
            '01-02',
            '12-23',
        ],
        2034 => '12-11',
        2035 => '12-01',
        2036 => '11-19',
        2037 => '11-09',
    ];

    public const sacrificeHolidays = [
        1970 => '02-17',
        1971 => '02-16',
        1972 => '01-27',
        1973 => '01-15',
        1974 => [
            '01-04',
            '12-24',
        ],
        1975 => '12-13',
        1976 => '12-02',
        1977 => '11-22',
        1978 => '11-11',
        1979 => '10-31',
        1980 => '10-19',
        1981 => '10-08',
        1982 => '09-27',
        1983 => '09-17',
        1984 => '09-06',
        1985 => '08-26',
        1986 => '08-16',
        1987 => '08-05',
        1988 => '07-24',
        1989 => '07-13',
        1990 => '07-03',
        1991 => '06-23',
        1992 => '06-11',
        1993 => '06-01',
        1994 => '05-21',
        1995 => '05-10',
        1996 => '04-28',
        1997 => '04-18',
        1998 => '04-07',
        1999 => '03-28',
        2000 => '03-16',
        2001 => '03-05',
        2002 => '02-22',
        2003 => '02-11',
        2004 => '02-01',
        2005 => '01-20',
        2006 => [
            '01-10',
            '12-31',
        ],
        2007 => '12-20',
        2008 => '12-08',
        2009 => '11-27',
        2010 => '11-16',
        2011 => '11-06',
        2012 => '10-25',
        2013 => '10-15',
        2014 => '10-04',
        2015 => '09-23',
        2016 => '09-12',
        2017 => '09-01',
        2018 => '08-21',
        2019 => '08-11',
        2020 => '07-31',
        2021 => '07-20',
        2022 => '07-09',
        2023 => '06-28',
        2024 => '06-16',
        2025 => '06-06',
        2026 => '05-26',
        2027 => '05-16',
        2028 => '05-04',
        2029 => '04-23',
        2030 => '04-13',
        2031 => '04-02',
        2032 => '03-21',
        2033 => '03-11',
        2034 => '02-28',
        2035 => '02-17',
        2036 => '02-07',
        2037 => '01-26',
    ];

    public function countryCode(): string
    {
        return 'tr';
    }

    protected function allHolidays(int $year): array
    {
        $newHolidays = [];

        if ($year >= 2009) {
            $newHolidays['Emek ve Dayanışma Günü'] = '05-01';
        }

        if ($year >= 2017) {
            $newHolidays['Demokrasi ve Millî Birlik Günü'] = '07-15';
        }

        return array_merge([
            'Yılbaşı' => '01-01',
            'Ulusal Egemenlik ve Çocuk Bayramı' => '04-23',
            'Atatürk\'ü Anma, Gençlik ve Spor Bayramı' => '05-19',
            'Zafer Bayramı' => '08-30',
            'Cumhuriyet Bayramı Arifesi' => '10-28',
            'Cumhuriyet Bayramı' => '10-29',
        ], $newHolidays, $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return array_merge([

        ], $this->getIslamicHolidays(
            year: $year,
            holidays: self::ramadanHolidays,
            label: 'Ramazan Bayramı',
            day: 3
        ), $this->getIslamicHolidays(
            year: $year,
            holidays: self::sacrificeHolidays,
            label: 'Kurban Bayramı',
            day: 4
        ));
    }

    /**
     * @param  array<int, string|array<string>>  $holidays
     * @return array<string, CarbonImmutable>
     */
    protected function getIslamicHolidays(
        int $year,
        array $holidays,
        string $label,
        int $day,
    ): array {
        $islamicHolidays = [];
        $counter = 0;

        if ($year != 1970) {
            $previousHoliday = is_array($holidays[$year - 1]) ? $holidays[$year - 1][1] : $holidays[$year - 1];

            $previousHoliday = CarbonImmutable::createFromFormat('Y-m-d', ($year - 1).'-'.$previousHoliday)
                ?: throw new RuntimeException('Date could not be created.');

            if ($previousHoliday->addDays($day - 1)->year == $year) {
                $islamicHolidays = $this->prepareHolidays(
                    holiday: $previousHoliday,
                    day: $day,
                    label: $label,
                    filterYear: $year
                );
                $counter++;
            }
        }

        $currentYearHolidays = is_array($holidays[$year]) ? $holidays[$year] : [$holidays[$year]];

        foreach ($currentYearHolidays as $currentYearHoliday) {
            $currentYearHoliday = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$currentYearHoliday}")
                ?: throw new RuntimeException('Date could not be created.');

            $islamicHolidays = array_merge($islamicHolidays, $this->prepareHolidays(
                holiday: $currentYearHoliday,
                day: $day,
                label: $label,
                filterYear: $year,
                prefix: $counter ? ($counter + 1).'. ' : ''
            ));
            $counter++;
        }

        if ($year != 2037) {
            $nextHoliday = is_array($holidays[$year + 1]) ? $holidays[$year + 1][1] : $holidays[$year + 1];

            $nextHoliday = CarbonImmutable::createFromFormat('Y-m-d', ($year + 1).'-'.$nextHoliday)
                ?: throw new RuntimeException('Date could not be created.');

            if ($nextHoliday->addDays(-1)->year == $year) {
                $islamicHolidays = array_merge($islamicHolidays, $this->prepareHolidays(
                    holiday: $nextHoliday,
                    day: $day,
                    label: $label,
                    filterYear: $year,
                    prefix: $counter ? ($counter + 1).'. ' : ''
                ));
            }
        }

        return $islamicHolidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function prepareHolidays(
        CarbonImmutable $holiday,
        int $day,
        string $label,
        int $filterYear,
        string $prefix = ''
    ): array {
        $holidays = [];

        $holidays[$prefix.$label.' Arifesi'] = $holiday->addDays(-1);
        foreach (range(1, $day) as $range) {
            $holidays[$prefix.$label.' '.$range.'. Gün'] = $holiday->addDays($range - 1);
        }

        return array_filter($holidays, fn ($holiday) => $holiday->year == $filterYear);
    }
}
