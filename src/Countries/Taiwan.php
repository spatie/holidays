<?php

namespace Spatie\Holidays\Countries;

use DateTime;
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
        return array_filter([
            'First day of the Lunar New Year' => '01-01',
            'Second day of the Lunar New Year' => '01-02',
            'Third day of the Lunar New Year' => '01-03',
            'Dragon Boat Festival' => '05-05',
            'Moon Festival' => '08-15',
        ], fn ($date) => $this->lunarCalendar($date, $year) !== null);
    }

    protected function lunarCalendar(string $input, int $year): ?string
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-TW@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );

        $lunarDateStr = $year . '-' . $input;
        $parsedTimestamp = $formatter->parse($lunarDateStr);

        if ($parsedTimestamp === false) {
            return null;
        }

        $dateTime = new DateTime;
        $dateTime->setTimestamp($parsedTimestamp);
        $dateTime->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('m-d');
    }
}
