<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait ChineseCalendar
{
    protected string $chineseCalendarTimezone = 'Asia/Shanghai';

    public function setChineseCalendarTimezone(string $chineseCalendarTimezone): static
    {
        $this->chineseCalendarTimezone = $chineseCalendarTimezone;

        return $this;
    }

    protected function chineseToGregorianDate(string $input, int $year): CarbonImmutable
    {
        $timestamp = (int) $this->getFormatter()->parse($year.'-'.$input);

        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->chineseCalendarTimezone));
    }

    protected function getFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: 'zh-CN@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->chineseCalendarTimezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }
}
