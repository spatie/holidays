<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait IndianCalendar
{
    protected string $indianCalendarTimezone = 'Asia/Singapore';
    protected string $indianLocale = 'zh-IN';

    public function setIndianCalendarTimezone(string $indianCalendarTimezone): static
    {
        $this->indianCalendarTimezone = $indianCalendarTimezone;

        return $this;
    }

    public function setIndianLocale(string $indianLocale): static
    {
        $this->indianLocale = $indianLocale;

        return $this;
    }

    protected function indianToGregorianDate(string $input, int $year): CarbonImmutable
    {
        $timestamp = (int) $this->getIndianFormatter()->parse($year.'-'.$input);

        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->indianCalendarTimezone));
    }

    protected function getIndianFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: $this->indianLocale . '@calendar=indian',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->indianCalendarTimezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }

}
