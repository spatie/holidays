<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Override;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Contracts\Islamic;
use Spatie\Holidays\Holiday;

class Ethiopia extends Country implements Islamic
{
    use IslamicCalendar;

    #[Override]
    public function countryCode(): string
    {
        return 'et';
    }

    #[Override]
    protected function supportedYearRange(): array
    {
        return [1970, 2037];
    }

    #[Override]
    protected function allHolidays(int $year): array
    {
        return array_merge($this->variableHolidays($year), $this->fixedHolidays($year));
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(int $year): array
    {
        return [
            Holiday::national('Ethiopian New Year', $this->meskeremDate($year, 1)),
            Holiday::national('Meskel', $this->meskeremDate($year, 17)),
            Holiday::national('Ethiopian Christmas', $this->januaryDate($year, 7)),
            Holiday::national('Epiphany', $this->timkatDate($year)),
            Holiday::national('Adwa Victory Day', "{$year}-03-02"),
            Holiday::national('May Day', "{$year}-05-01"),
            Holiday::national("Patriots' Victory Day", "{$year}-05-05"),
            Holiday::national('Derg Downfall Day', "{$year}-05-28"),
        ];
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return array_merge([
            Holiday::national('Siklet', $easter->subDays(2)),
            Holiday::national('Fasika', $easter),
        ], $this->islamicHolidays($year));
    }

    private function meskeremDate(int $year, int $day): CarbonImmutable
    {
        $leapShift = $this->createDate('Y-m-d', ($year + 1).'-01-01')->isLeapYear() ? 1 : 0;

        return $this->createDate('Y-m-d', "{$year}-09-10")->addDays($day + $leapShift);
    }

    private function timkatDate(int $year): CarbonImmutable
    {
        return $this->januaryDate($year, 19);
    }

    private function januaryDate(int $year, int $day): CarbonImmutable
    {
        $day += $this->createDate('Y-m-d', "{$year}-01-01")->isLeapYear() ? 1 : 0;

        return $this->createDate('Y-m-d', "{$year}-01-{$day}");
    }

    protected function eidAlFitrDates(): array
    {
        return [
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
            2025 => '03-30',
            2026 => '03-20',
            2027 => '03-09',
            2028 => '02-26',
            2029 => '02-14',
            2030 => '02-04',
            2031 => '01-24',
            2032 => '01-14',
            2033 => [
                '01-02',
                '12-23',
            ],
            2034 => '12-12',
            2035 => '12-01',
            2036 => '11-19',
            2037 => '11-09',
        ];
    }

    protected function eidAlAdhaDates(): array
    {
        return [
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
            2026 => '05-27',
            2027 => '05-16',
            2028 => '05-05',
            2029 => '04-24',
            2030 => '04-13',
            2031 => '04-02',
            2032 => '03-22',
            2033 => '03-11',
            2034 => '03-01',
            2035 => '02-18',
            2036 => '02-07',
            2037 => '01-26',
        ];
    }

    /** @return array<int, string> */
    protected function prophetMuhammadBirthdayDates(): array
    {
        return [
            1970 => '05-18',
            1971 => '05-08',
            1972 => '04-26',
            1973 => '04-15',
            1974 => '04-05',
            1975 => '03-25',
            1976 => '03-13',
            1977 => '03-03',
            1978 => '02-20',
            1979 => '02-10',
            1980 => '01-30',
            1981 => '01-18',
            1982 => '01-08',
            1983 => '12-17',
            1984 => '12-06',
            1985 => '11-25',
            1986 => '11-15',
            1987 => '11-04',
            1988 => '10-23',
            1989 => '10-13',
            1990 => '10-02',
            1991 => '09-21',
            1992 => '09-10',
            1993 => '08-30',
            1994 => '08-19',
            1995 => '08-09',
            1996 => '07-28',
            1997 => '07-18',
            1998 => '07-07',
            1999 => '06-26',
            2000 => '06-15',
            2001 => '06-04',
            2002 => '05-24',
            2003 => '05-14',
            2004 => '05-02',
            2005 => '04-21',
            2006 => '04-11',
            2007 => '03-31',
            2008 => '03-20',
            2009 => '03-09',
            2010 => '02-26',
            2011 => '02-16',
            2012 => '02-05',
            2013 => '01-24',
            2014 => '01-13',
            2015 => '12-23',
            2016 => '12-12',
            2017 => '12-01',
            2018 => '11-20',
            2019 => '11-09',
            2020 => '10-29',
            2021 => '10-21',
            2022 => '10-08',
            2023 => '09-27',
            2024 => '09-15',
            2025 => '09-05',
            2026 => '08-25',
            2027 => '08-15',
            2028 => '08-03',
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
    }

    /** @return array<Holiday> */
    public function islamicHolidays(int $year): array
    {
        return array_merge(
            [
                Holiday::religious('Mawlid', $this->prophetMuhammadBirthday($year)),
            ],
            $this->singleDayIslamicHolidays('Eid al-Adha', $this->eidAlAdhaDates(), $year),
            $this->singleDayIslamicHolidays('Eid al-Fitr', $this->eidAlFitrDates(), $year),
        );
    }

    /**
     * @param  array<int, string|array<string>>  $dates
     * @return array<Holiday>
     */
    private function singleDayIslamicHolidays(string $name, array $dates, int $year): array
    {
        $dates = (array) $dates[$year];

        return array_map(
            fn (string $date): Holiday => Holiday::religious($name, "{$year}-{$date}"),
            $dates,
        );
    }
}
