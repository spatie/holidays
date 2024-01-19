<?php

namespace Spatie\Holidays\Countries;

use DateTimeZone;
use IntlDateFormatter;

class Taiwan extends Country
{
    protected string $timezone = 'Asia/Taipei';

    public function countryCode(): string
    {
        return 'tw';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Peace Memorial Day' => '02-28',
            'Children\'s Day' => '04-04',
            'National Day' => '10-10',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string> */
    protected function variableHolidays(int $year): array
    {
        return [
            'First day of the Lunar New Year' => $this->lunarCalendar('01-01', $year),
            'Second day of the Lunar New Year' => $this->lunarCalendar('01-02', $year),
            'Third day of the Lunar New Year' => $this->lunarCalendar('01-03', $year),
            'Dragon Boat Festival' => $this->lunarCalendar('05-05', $year),
            'Moon Festival' => $this->lunarCalendar('08-15', $year),
        ];
    }

    protected function lunarCalendar(string $input, int $year): string
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-TW@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );

        return date_create()
            ->setTimeStamp($formatter->parse($year . '-' . $input))
            ->setTimezone(new DateTimeZone($this->timezone))
            ->format('m-d');
    }
}
