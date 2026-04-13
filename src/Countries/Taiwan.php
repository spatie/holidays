<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Holiday;

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
            Holiday::national('元旦', "{$year}-01-01"),
            Holiday::national('228和平紀念日', "{$year}-02-28"),
            Holiday::national('兒童節', "{$year}-04-04"),
            Holiday::national('雙十國慶', "{$year}-10-10"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $holidays = [];
        $dates = [
            '農曆春節-正月初一' => '01-01',
            '農曆春節-正月初二' => '01-02',
            '農曆春節-正月初三' => '01-03',
            '端午節' => '05-05',
            '中秋節' => '08-15',
        ];

        foreach ($dates as $name => $date) {
            $holidayDate = $this->lunarCalendar($date, $year);
            if ($holidayDate !== null) {
                $holidays[] = Holiday::national($name, $holidayDate);
            }
        }

        return $holidays;
    }

    protected function lunarCalendar(string $input, int $year): ?CarbonImmutable
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-TW@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );

        $lunarDateStr = "{$year}-{$input}";
        $parsedTimestamp = $formatter->parse($lunarDateStr);

        if ($parsedTimestamp === false) {
            return null;
        }

        $dateTime = new DateTime;
        $dateTime->setTimestamp((int) $parsedTimestamp);
        $dateTime->setTimezone(new DateTimeZone($this->timezone));

        return new CarbonImmutable($dateTime->format('Y-m-d'));
    }
}
