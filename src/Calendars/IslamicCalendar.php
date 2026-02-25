<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Exceptions\InvalidYear;

/** @mixin Country */
trait IslamicCalendar
{
    use ResolvesCalendarDates;

    protected string $islamicCalendarTimezone = 'UTC';

    /** @return array<CarbonPeriod> */
    public function eidAlFitr(int $year, int $totalDays = 3): array
    {
        return $this->getMultiDayHoliday(self::eidAlFitr, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    public function eidAlAdha(int $year, int $totalDays = 4): array
    {
        return $this->getMultiDayHoliday(self::eidAlAdha, $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    protected function ashura(int $year, int $totalDays = 2): array
    {
        return $this->getMultiDayHoliday(self::ashura, $year, $totalDays);
    }

    protected function arafat(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday(self::arafat, $year);
    }

    protected function islamicNewYear(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday(self::islamicNewYear, $year);
    }

    protected function prophetMuhammadBirthday(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday(self::prophetMuhammadBirthday, $year);
    }

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

        $dateTime = DateTime::createFromFormat('d/m/Y', '01/01/'.($nextYear ? $year + 1 : $year));

        if (! $dateTime) {
            throw InvalidYear::invalidHijriYear();
        }

        return (int) $formatter->format($dateTime->getTimestamp());
    }

    protected function islamicToGregorianDate(string $input, int $year, bool $nextYear = false): CarbonImmutable
    {
        $hijriYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        $formatter = $this->getIslamicCalendarFormatter();
        $timestamp = (int) $formatter->parse(sprintf('%s-%s', $hijriYear, $input));

        return (new CarbonImmutable)
            ->setTimeStamp($timestamp)
            ->setTimezone(new DateTimeZone($this->islamicCalendarTimezone));
    }
}
