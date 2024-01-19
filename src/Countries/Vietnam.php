<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

class Vietnam extends Country
{
    protected $timezone = 'Asia/Ho_Chi_Minh';

    public function countryCode(): string
    {
        return 'vi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s day' => '01-01',
            'Reunification Day' => '04-30',
            'Labour Day' => '05-01',
            'Independence Day' => '09-02',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Lunar New Year\'s Eve' => $this->chineseCalendar('01/01', $year),
            'Lunar New Year Day 1' => $this->chineseCalendar('01/01', $year),
            'Lunar New Year Day 2' => $this->chineseCalendar('01/02', $year),
            'Lunar New Year Day 3' => $this->chineseCalendar('01/03', $year),
            'Lunar New Year Day 4' => $this->chineseCalendar('01/04', $year),
            'Hung Kings\' Festival' => $this->chineseCalendar('03/10', $year),
        ];
    }

    protected function chineseCalendar(string $input, int $year): string
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-CN@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );

        $timeStamp = $formatter->parse($year . '/' . $input);
        $dateTime = date_create()->setTimeStamp($timeStamp)->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('m-d');
    }
}
