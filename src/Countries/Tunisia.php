<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Calendars\HijriCalendar;

class Tunisia extends Country
{
    use HijriCalendar;

    /**
     * @return string
     */
    public function countryCode(): string
    {
        return 'tn';
    }

    /**
     * @param int $year
     * @return array|CarbonImmutable[]|string[]
     */
    protected function allHolidays(int $year): array
    {
        $revolutionHoliday = [];

        if (2022 > $year and $year >= 2011) {
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
                holidays: self::$islamicNewYear,
                label: 'Islamic new year'
            ),
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::$prophetMohammedBirthday,
                label: 'Birthday of the Prophet Mohamed'
            ),
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::$eidAlFitr,
                label: 'Eid al-Fitr',
                day: 2
            ),
            $this->getIslamicHolidays(
                year: $year,
                holidays: self::$eidAlAdha,
                label: 'Eid al-Adha',
                day: 3
            )
        );
    }
}
