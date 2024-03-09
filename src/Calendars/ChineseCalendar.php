<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait ChineseCalendar
{
    protected string $chineseCalendarTimezone = 'Asia/Shanghai';
    protected string $chineseLocale = 'zh-SG';

    public function setChineseCalendarTimezone(string $chineseCalendarTimezone): static
    {
        $this->chineseCalendarTimezone = $chineseCalendarTimezone;

        return $this;
    }

    public function setChineseLocale(string $chineseLocale): static
    {
        $this->chineseLocale = $chineseLocale;

        return $this;
    }

    protected function chineseToGregorianDate(string $input, int $year): CarbonImmutable
    {
        $timestamp = (int) $this->getChineseFormatter()->parse($year.'-'.$input);

        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->chineseCalendarTimezone));
    }

    protected function getChineseFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: $this->chineseLocale . '@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->chineseCalendarTimezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }
}
