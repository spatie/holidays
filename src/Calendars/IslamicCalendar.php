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

    /** @return array<int, string|array<string>> */
    abstract protected function eidAlFitrDates(): array;

    /** @return array<int, string|array<string>> */
    abstract protected function eidAlAdhaDates(): array;

    /** @return array<int, string> */
    protected function ashuraDates(): array
    {
        return [];
    }

    /** @return array<int, string> */
    protected function arafatDates(): array
    {
        return [];
    }

    /** @return array<int, string> */
    protected function islamicNewYearDates(): array
    {
        return [];
    }

    /** @return array<int, string> */
    protected function prophetMuhammadBirthdayDates(): array
    {
        return [];
    }

    /** @return array<CarbonPeriod> */
    public function eidAlFitr(int $year, int $totalDays = 3): array
    {
        return $this->getMultiDayHoliday($this->eidAlFitrDates(), $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    public function eidAlAdha(int $year, int $totalDays = 4): array
    {
        return $this->getMultiDayHoliday($this->eidAlAdhaDates(), $year, $totalDays);
    }

    /** @return array<CarbonPeriod> */
    protected function ashura(int $year, int $totalDays = 2): array
    {
        return $this->getMultiDayHoliday($this->ashuraDates(), $year, $totalDays);
    }

    protected function arafat(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday($this->arafatDates(), $year);
    }

    protected function islamicNewYear(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday($this->islamicNewYearDates(), $year);
    }

    protected function prophetMuhammadBirthday(int $year): CarbonImmutable
    {
        return $this->getSingleDayHoliday($this->prophetMuhammadBirthdayDates(), $year);
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
