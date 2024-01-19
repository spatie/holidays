<?php

namespace Spatie\Holidays\Calendars;

use DateTimeZone;
use IntlDateFormatter;

trait ChineseCalendar
{
    protected $timezone = 'Asia/Shanghai';

    protected function chineseToGregorianDate(string $input, int $year): string
    {
        $timeStamp = $this->getFormatter()->parse($year . '/' . $input);
        $dateTime = date_create()->setTimeStamp($timeStamp)->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('m-d');
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