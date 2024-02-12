<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Tunisia extends Country
{
    private const IslamicNewYear = [
        1970 => "03-08",
        1971 => "02-26",
        1973 => "02-03",
        1972 => "02-15",
        1974 => "01-24",
        1975 => "01-13",
        1976 => "12-22",
        1977 => "12-11",
        1978 => "12-01",
        1979 => "11-20",
        1980 => "11-08",
        1981 => "10-29",
        1982 => "10-18",
        1983 => "10-07",
        1984 => "09-26",
        1985 => "09-15",
        1986 => "09-05",
        1987 => "08-25",
        1988 => "08-13",
        1989 => "08-03",
        1990 => "07-23",
        1991 => "07-12",
        1992 => "07-01",
        1993 => "06-20",
        1994 => "06-09",
        1995 => "05-30",
        1996 => "05-18",
        1997 => "05-08",
        1998 => "04-27",
        1999 => "04-16",
        2000 => "04-05",
        2001 => "03-25",
        2002 => "03-14",
        2003 => "03-04",
        2004 => "02-21",
        2005 => "02-09",
        2006 => "01-30",
        2007 => "01-19",
        2008 => "12-28",
        2009 => "12-17",
        2010 => "12-07",
        2011 => "11-26",
        2012 => "11-14",
        2013 => "11-04",
        2014 => "10-24",
        2015 => "10-14",
        2016 => "10-02",
        2017 => "09-21",
        2018 => "09-11",
        2019 => "08-31",
        2020 => "08-19",
        2021 => "08-09",
        2022 => "07-29",
        2023 => "07-18",
        2024 => "07-07",
        2025 => "06-26",
        2026 => "06-16",
        2027 => "06-05",
        2028 => "05-24",
        2029 => "05-14",
        2030 => "05-03",
        2031 => "04-22",
        2032 => "04-11",
        2033 => "03-31",
        2034 => "03-20",
        2035 => "03-10",
        2036 => "02-27",
        2037 => "02-16"
    ];
    public const ProphetMohammedBirthday = [
        1970 => "05-17",
        1971 => "05-07",
        1972 => "04-25",
        1973 => "04-14",
        1974 => "04-04",
        1975 => "03-24",
        1976 => "03-02",
        1977 => "02-19",
        1978 => "02-09",
        1979 => "01-29",
        1980 => "01-17",
        1981 => "01-07",
        1982 => "12-27",
        1983 => "12-16",
        1984 => "12-05",
        1985 => "11-24",
        1986 => "11-14",
        1987 => "11-03",
        1988 => "10-22",
        1989 => "10-12",
        1990 => "10-01",
        1991 => "09-20",
        1992 => "09-09",
        1993 => "08-29",
        1994 => "08-18",
        1995 => "08-08",
        1996 => "07-27",
        1997 => "07-17",
        1998 => "07-06",
        1999 => "06-25",
        2000 => "06-14",
        2001 => "06-03",
        2002 => "05-23",
        2003 => "05-13",
        2004 => "05-01",
        2005 => "04-20",
        2006 => "04-10",
        2007 => "03-30",
        2008 => "03-08",
        2009 => "02-25",
        2010 => "02-15",
        2011 => "02-04",
        2012 => "01-23",
        2013 => "01-13",
        2014 => "01-02",
        2015 => "12-23",
        2016 => "12-11",
        2017 => "11-30",
        2018 => "11-20",
        2019 => "11-09",
        2020 => "10-28",
        2021 => "10-18",
        2022 => "10-07",
        2023 => "09-26",
        2024 => "09-15",
        2025 => "09-04",
        2026 => "08-25",
        2027 => "08-14",
        2028 => "08-02",
        2029 => "07-23",
        2030 => "07-12",
        2031 => "07-01",
        2032 => "06-20",
        2033 => "06-09",
        2034 => "05-29",
        2035 => "05-19",
        2036 => "05-07",
        2037 => "04-27"
    ];
    public const EidAlFitr = [
        1970 => "12-11",
        1971 => "11-30",
        1972 => "11-20",
        1973 => "11-08",
        1974 => "10-28",
        1975 => "10-18",
        1976 => "10-07",
        1977 => "09-15",
        1978 => "09-04",
        1979 => "08-25",
        1980 => "08-13",
        1981 => "08-02",
        1982 => "07-23",
        1983 => "07-12",
        1984 => "06-30",
        1985 => "06-20",
        1986 => "06-09",
        1987 => "05-30",
        1988 => "05-18",
        1989 => "05-07",
        1990 => "04-27",
        1991 => "04-16",
        1992 => "04-04",
        1993 => "03-25",
        1994 => "03-14",
        1995 => "03-03",
        1996 => "02-21",
        1997 => "02-09",
        1998 => "01-30",
        1999 => "01-19",
        2000 => "01-08",
        2001 => "12-28",
        2002 => "12-17",
        2003 => "12-06",
        2004 => "11-26",
        2005 => "11-14",
        2006 => "11-03",
        2007 => "10-24",
        2008 => "10-13",
        2009 => "09-21",
        2010 => "09-10",
        2011 => "08-31",
        2012 => "08-19",
        2013 => "08-08",
        2014 => "07-29",
        2015 => "07-18",
        2016 => "07-07",
        2017 => "06-26",
        2018 => "06-15",
        2019 => "06-05",
        2020 => "05-24",
        2021 => "05-13",
        2022 => "05-03",
        2023 => "04-22",
        2024 => "04-10",
        2025 => "03-31",
        2026 => "03-20",
        2027 => "03-10",
        2028 => "02-27",
        2029 => "02-15",
        2030 => "02-05",
        2031 => "01-25",
        2032 => "01-14",
        2033 => "01-03",
        2034 => "12-23",
        2035 => "12-12",
        2036 => "12-02",
        2037 => "11-20",
    ];
    public const EidAlAdha = [
        1970 => "02-17",
        1971 => "02-06",
        1972 => "01-27",
        1973 => "01-15",
        1974 => "01-04",
        1975 => "12-25",
        1976 => "12-14",
        1977 => "11-22",
        1978 => "11-11",
        1979 => "11-01",
        1980 => "10-20",
        1981 => "10-09",
        1982 => "09-29",
        1983 => "09-18",
        1984 => "09-06",
        1985 => "08-27",
        1986 => "08-16",
        1987 => "08-06",
        1988 => "07-25",
        1989 => "07-14",
        1990 => "07-04",
        1991 => "06-23",
        1992 => "06-11",
        1993 => "06-01",
        1994 => "05-21",
        1995 => "05-10",
        1996 => "04-29",
        1997 => "04-18",
        1998 => "04-08",
        1999 => "03-28",
        2000 => "03-16",
        2001 => "03-06",
        2002 => "02-23",
        2003 => "02-12",
        2004 => "02-02",
        2005 => "01-21",
        2006 => "01-10",
        2007 => "12-31",
        2008 => "12-20",
        2009 => "11-28",
        2010 => "11-17",
        2011 => "11-07",
        2012 => "10-26",
        2013 => "10-15",
        2014 => "10-05",
        2015 => "09-24",
        2016 => "09-13",
        2017 => "09-02",
        2018 => "08-22",
        2019 => "08-12",
        2020 => "07-31",
        2021 => "07-20",
        2022 => "07-10",
        2023 => "06-29",
        2024 => "06-17",
        2025 => "06-07",
        2026 => "05-27",
        2027 => "05-17",
        2028 => "05-05",
        2029 => "04-24",
        2030 => "04-14",
        2031 => "04-03",
        2032 => "03-22",
        2033 => "03-12",
        2034 => "03-01",
        2035 => "02-18",
        2036 => "02-08",
        2037 => "01-27",
    ];

    /**
     * @return string
     */
    public function countryCode(): string
    {
        return 'tn';
    }

    protected function allHolidays(int $year): array
    {
        $revolutionHoliday = [];

        if (2022 > $year && $year >= 2011) {
            $revolutionHoliday['Revolution and Youth Day'] = '01-14';
        }

        if ($year >= 2022) {
            $revolutionHoliday['Revolution and Youth Day'] = '12-17';
        }

        return array_merge([
            'New Year\'s Day' => '01-01',
            'Independence Day' => '03-20',
            'Martyrs\' Day' => '04-09',
            'Labour Day' => '05-01',
            'Republic Day' => '07-25',
            'Women\'s Day' => '08-13',
            'Evacuation Day' => '10-15',
        ], $revolutionHoliday, $this->variableHolidays($year));
    }

    /**
     * The following holidays are considered public holidays in Tunisia. However, their dates vary each year,
     * as they are based on the Islamic Hijri (lunar) calendar. These holidays do not have a fixed date and
     * occur based on the lunar calendar sequence. The order listed reflects the chronological occurrence
     * of these holidays throughout the year.
     * @param int $year
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        return array_merge(
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::IslamicNewYear,
                label: 'Islamic new year'
            ),
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::ProphetMohammedBirthday,
                label: 'Birthday of the Prophet Mohamed'
            ),
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::EidAlFitr,
                label: 'Eid al-Fitr',
                day: 2
            ),
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::EidAlAdha,
                label: 'Eid al-Adha',
                day: 3
            )
        );
    }

    /**
     * @param array<int, string|array<string>> $holidays
     * @return array<string, CarbonImmutable>
     */
    protected function getIslamicHolidays(
        int    $year,
        array  $holidays,
        string $label,
        int    $day = 1,
    ): array
    {
        $islamicHolidays = [];
        $counter = 0;

        if ($year != 1970) {
            $previousHoliday = is_array($holidays[$year - 1]) ? $holidays[$year - 1][1] : $holidays[$year - 1];

            $previousHoliday = CarbonImmutable::createFromFormat('Y-m-d', ($year - 1) . '-' . $previousHoliday)
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
                prefix: $counter ? ($counter + 1) . '. ' : ''
            ));
            $counter++;
        }

        if ($year != 2037) {
            $nextHoliday = is_array($holidays[$year + 1]) ? $holidays[$year + 1][1] : $holidays[$year + 1];

            $nextHoliday = CarbonImmutable::createFromFormat('Y-m-d', ($year + 1) . '-' . $nextHoliday)
                ?: throw new RuntimeException('Date could not be created.');

            if ($nextHoliday->addDays(-1)->year == $year) {
                $islamicHolidays = array_merge($islamicHolidays, $this->prepareHolidays(
                    holiday: $nextHoliday,
                    day: $day,
                    label: $label,
                    filterYear: $year,
                    prefix: $counter ? ($counter + 1) . '. ' : ''
                ));
            }
        }

        return $islamicHolidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function prepareHolidays(
        CarbonImmutable $holiday,
        int             $day,
        string          $label,
        int             $filterYear,
        string          $prefix = ''
    ): array
    {
        $holidays = [];

        foreach (range(1, $day) as $range) {
            $holidays[$prefix . $label . ' ' . $range . '. Day'] = $holiday->addDays($range - 1);
        }

        return array_filter($holidays, fn($holiday) => $holiday->year == $filterYear);
    }
}
