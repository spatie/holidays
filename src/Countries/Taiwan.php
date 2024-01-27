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
            '元旦' => '01-01',
            '228和平紀念日' => '02-28',
            '兒童節' => '04-04',
            '雙十國慶' => '10-10',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string> */
    protected function variableHolidays(int $year): array
    {
        return array_filter(array_map(fn ($date) => $this->lunarCalendar($date, $year), [
            '農曆春節-正月初一' => '01-01',
            '農曆春節-正月初二' => '01-02',
            '農曆春節-正月初三' => '01-03',
            '端午節' => '05-05',
            '中秋節' => '08-15',
        ]));
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

        $lunarDateStr = $year.'-'.$input;
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
