<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
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
            '元旦' => CarbonImmutable::createFromDate($year, 1, 1),
            '228和平紀念日' => CarbonImmutable::createFromDate($year, 2, 28),
            '兒童節' => CarbonImmutable::createFromDate($year, 4, 4),
            '雙十國慶' => CarbonImmutable::createFromDate($year, 10, 10),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return array_filter(array_map(fn (string $date): ?CarbonImmutable => $this->lunarCalendar($date, $year), [
            '農曆春節-正月初一' => '01-01',
            '農曆春節-正月初二' => '01-02',
            '農曆春節-正月初三' => '01-03',
            '端午節' => '05-05',
            '中秋節' => '08-15',
        ]));
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
