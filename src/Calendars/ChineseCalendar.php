<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait ChineseCalendar
{
    protected string $timezone = 'Asia/Shanghai';

    public function setTimezoneForChineseCalendar(string $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
    }

    protected function chineseToGregorianDate(string $input, int $year): CarbonImmutable
    {
        $timestamp = (int) $this->getFormatter()->parse($year . '/' . $input);
        
        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->timezone));
    }

    protected function getFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: 'zh-CN@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }
}