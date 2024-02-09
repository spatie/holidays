<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlCalendar;
use IntlDateFormatter;
use Spatie\Holidays\Exceptions\InvalidYear;

trait IslamicCalendar
{
    protected string $islamicCalendarTimezone = 'UTC';

    public function setIslamicCalendarTimezone(string $islamicCalendarTimezone): static
    {
        $this->islamicCalendarTimezone = $islamicCalendarTimezone;

        return $this;
    }

    protected function getIslamicCalendarFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            'en_US@calendar=islamic-civil',
            IntlDateFormatter::FULL,
            IntlDateFormatter::FULL,
            'UTC',
            IntlDateFormatter::TRADITIONAL,
            'yyyy-MM-dd'
        );
    }

    protected function getHijriYear(int $year, bool $nextYear = false): int
    {
        $formatter = $this->getIslamicCalendarFormatter();
        $formatter->setPattern('yyyy');
        $dateTime = DateTime::createFromFormat('d/m/Y', '01/01/' . ($nextYear ? $year + 1 : $year));

        if (!$dateTime) {
            throw InvalidYear::invalidHijriYear();
        }

        return (int) $formatter->format($dateTime->getTimestamp());
    }

    protected function islamicToGregorianDate(string $input, int $year, bool $nextYear = false): CarbonImmutable
    {
        $hijriYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        $formatter = $this->getIslamicCalendarFormatter();
        $timestamp = (int) $formatter->parse(sprintf('%s-%s', $hijriYear, $input));

        return (new CarbonImmutable())
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->islamicCalendarTimezone));
    }
}