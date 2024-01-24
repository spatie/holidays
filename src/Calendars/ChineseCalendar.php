<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait ChineseCalendar
{
    protected string $asianTimezone = 'Asia/Shanghai';

    public function setTimezoneForChineseCalendar(string $asianTimezone): static
    {
        $this->asianTimezone = $asianTimezone;

        return $this;
    }

    protected function chineseToGregorianDate(string $input, int $year): CarbonImmutable
    {
        $timestamp = (int) $this->getFormatter()->parse($year . '-' . $input);
        
        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->asianTimezone));
    }

    protected function getFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: 'zh-CN@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->asianTimezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }
}