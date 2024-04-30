<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Uzbekistan extends Country implements HasTranslations
{
    use Translatable;

    /**
     * Islamic holidays (Ramadan & Sacrifice) are obtained constantly from 1991 to 2037 (https://www.timeanddate.com/holidays/uzbekistan/)
     */
    protected const ramadanHolidays = [
        1991 => '04-16',
        1992 => '04-04',
        1993 => '03-25',
        1994 => '03-14',
        1995 => '03-03',
        1996 => '02-21',
        1997 => '02-09',
        1998 => '01-30',
        1999 => '01-19',
        2000 => [
            '01-08',
            '12-28',
        ],
        2001 => '12-17',
        2002 => '12-06',
        2003 => '11-26',
        2004 => '11-14',
        2005 => '11-04',
        2006 => '10-24',
        2007 => '10-13',
        2008 => '10-02',
        2009 => '09-21',
        2010 => '09-10',
        2011 => '08-31',
        2012 => '08-19',
        2013 => '08-08',
        2014 => '07-29',
        2015 => '07-18',
        2016 => '07-07',
        2017 => '06-26',
        2018 => '06-15',
        2019 => '06-04',
        2020 => '05-24',
        2021 => '05-13',
        2022 => '05-02',
        2023 => '04-21',
        2024 => '04-10',
        2025 => '03-31',
        2026 => '03-20',
        2027 => '03-10',
        2028 => '02-27',
        2029 => '02-15',
        2030 => '02-05',
        2031 => '01-25',
        2032 => '01-14',
        2033 => [
            '01-03',
            '12-23',
        ],
        2034 => '12-12',
        2035 => '12-02',
        2036 => '11-20',
        2037 => '11-10',
    ];

    public const sacrificeHolidays = [
        1991 => '06-23',
        1992 => '06-11',
        1993 => '06-01',
        1994 => '05-21',
        1995 => '05-10',
        1996 => '04-29',
        1997 => '04-18',
        1998 => '04-08',
        1999 => '03-28',
        2000 => '03-16',
        2001 => '03-06',
        2002 => '02-23',
        2003 => '02-12',
        2004 => '02-02',
        2005 => '01-21',
        2006 => [
            '01-10',
            '12-31',
        ],
        2007 => '12-20',
        2008 => '12-09',
        2009 => '11-28',
        2010 => '11-17',
        2011 => '11-07',
        2012 => '10-26',
        2013 => '10-15',
        2014 => '10-05',
        2015 => '09-24',
        2016 => '09-13',
        2017 => '09-02',
        2018 => '08-22',
        2019 => '08-11',
        2020 => '07-31',
        2021 => '07-20',
        2022 => '07-09',
        2023 => '06-28',
        2024 => '06-17',
        2025 => '06-07',
        2026 => '05-27',
        2027 => '05-17',
        2028 => '05-05',
        2029 => '04-24',
        2030 => '04-14',
        2031 => '04-03',
        2032 => '03-22',
        2033 => '03-12',
        2034 => '03-01',
        2035 => '02-18',
        2036 => '02-08',
        2037 => '01-27',
    ];

    public function countryCode(): string
    {
        return 'uz';
    }

    public function defaultLocale(): string
    {
        return 'uz';
    }

    /** @return array<string, CarbonImmutable|string> */
    protected function allHolidays(int $year): array
    {
        //After gaining independence on September 1, 1991, Uzbekistan introduced a new set of public holidays.
        if ($year < 1991) {
            return [];
        }

        return array_merge([
            'Yangi yil' => '01-01',
            'Xalqaro xotin-qizlar kuni' => '03-08',
            'Navro\'z' => '03-21',
            'Xotira va qadrlash kuni' => '05-09',
            'Mustaqillik kuni' => '09-01',
            'Ustoz va murabbiylar kuni' => '10-01',
            'Konstitutsiya kuni' => '12-08',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable|string> */
    protected function variableHolidays(int $year): array
    {
        $holidays = [];

        if (isset(self::ramadanHolidays[$year])) {
            foreach ((array) self::ramadanHolidays[$year] as $key => $holiday) {
                $prefix = $key == 0 ? '' : ' '.($key + 1);
                $holidays['Ramazon Hayiti'.$prefix] = $holiday;
            }
        }
        if (isset(self::sacrificeHolidays[$year])) {
            foreach ((array) self::sacrificeHolidays[$year] as $key => $holiday) {
                $prefix = $key == 0 ? '' : ' '.($key + 1);
                $holidays['Qurbon Hayiti'.$prefix] = $holiday;
            }
        }

        return $holidays;
    }
}
