<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait IslamicCalendar
{
    protected string $islamicCalendarTimezone = 'Asia/Singapore';
    protected string $islamicLocale = 'en-SG';

    public function setIslamicCalendarTimezone(string $islamicCalendarTimezone): static
    {
        $this->islamicCalendarTimezone = $islamicCalendarTimezone;

        return $this;
    }

    public function setIslamicLocale(string $islamicLocale): static
    {
        $this->islamicLocale = $islamicLocale;

        return $this;
    }

    protected function islamicToGregorianDate(string $input, int $year, int $nextYear = 0): CarbonImmutable
    {
        $hijriYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        
        $timestamp = (int) $this->getIslamicFormatter()->parse($input . '/' . $hijriYear . ' AH');

        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->islamicCalendarTimezone));
    }

    protected function getIslamicFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: $this->islamicLocale . '@calendar=islamic-civil',
            dateType: IntlDateFormatter::MEDIUM,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->islamicCalendarTimezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }
    
    protected function getHijriYear(int $year, int $nextYear = 0): int
    {
        $formatter = $this->getIslamicFormatter();
        $formatter->setPattern('yyyy');

        /** @var CarbonImmutable $dateTime */
        $dateTime = CarbonImmutable::createFromFormat("d/m/Y", '01/01/' . ($year + $nextYear));

        $hijriYear = $formatter->format($dateTime);

        return (int) $hijriYear;
    }
}
