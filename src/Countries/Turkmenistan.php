<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Holiday;

class Turkmenistan extends Country
{
    protected string $timezone = 'Asia/Ashgabat';

    public function countryCode(): string
    {
        return 'tm';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Täze ýyl', "{$year}-01-01"),
            Holiday::national('Halkara zenanlar güni', "{$year}-03-08"),
            Holiday::national('Milli bahar baýramy 1-nji güni', "{$year}-03-21"),
            Holiday::national('Milli bahar baýramy 2-nji güni', "{$year}-03-22"),
            Holiday::national('Türkmenistanyň Konstitusiýasynyň we Türkmenistanyň Döwlet baýdagynyň güni', "{$year}-05-18"),
            Holiday::national('Türkmenistanyň Garaşsyzlyk güni', "{$year}-09-27"),
            Holiday::national('Hatyra güni', "{$year}-10-06"),
            Holiday::national('Halkara Bitaraplyk güni', "{$year}-12-12"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [
            Holiday::national('Oraza baýramy', $this->islamicCalendar('01-10', $year)),
            Holiday::national('Gurban baýramy 1-nji güni', $this->islamicCalendar('10-12', $year)),
            Holiday::national('Gurban baýramy 2-nji güni', $this->islamicCalendar('11-12', $year)),
            Holiday::national('Gurban baýramy 3-nji güni', $this->islamicCalendar('12-12', $year)),
        ];
    }

    protected function islamicCalendar(string $input, int $year, bool $nextYear = false): CarbonImmutable
    {
        $hijriYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        $formatter = $this->getIslamicFormatter();

        $timeStamp = $formatter->parse("{$input}/{$hijriYear} AH");
        if ($timeStamp === false) {
            throw new \RuntimeException("Failed to parse hijri date: {$input}/{$hijriYear} AH");
        }

        $dateTime = new DateTime;
        $dateTime->setTimestamp((int) $timeStamp);
        $dateTime = $dateTime->setTimezone(new DateTimeZone($this->timezone));

        return new CarbonImmutable($dateTime->format('Y-m-d'));
    }

    protected function getIslamicFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: 'en-SG@calendar=islamic-civil',
            dateType: IntlDateFormatter::MEDIUM,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }

    protected function getHijriYear(int $year, bool $nextYear = false): int
    {
        $formatter = $this->getIslamicFormatter();
        $formatter->setPattern('yyyy');

        $dateTime = DateTime::createFromFormat('d/m/Y', '01/01/'.($nextYear ? $year + 1 : $year));
        if ($dateTime === false) {
            throw new \RuntimeException('Failed to create datetime');
        }

        $formatted = $formatter->format($dateTime);
        if ($formatted === false) {
            throw new \RuntimeException('Failed to format hijri year');
        }

        return (int) $formatted;
    }
}
