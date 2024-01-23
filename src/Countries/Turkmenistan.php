<?php

namespace Spatie\Holidays\Countries;

use DateTime;
use DateTimeZone;
use IntlDateFormatter;

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
            'Täze ýyl' => '01-01',
            'Halkara zenanlar güni' => '03-08',
            'Milli bahar baýramy 1-nji güni' => '03-21',
            'Milli bahar baýramy 2-nji güni' => '03-22',
            'Türkmenistanyň Konstitusiýasynyň we Türkmenistanyň Döwlet baýdagynyň güni' => '05-18',
            'Türkmenistanyň Garaşsyzlyk güni' => '09-27',
            'Hatyra güni' => '10-06',
            'Halkara Bitaraplyk güni' => '12-12',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Oraza baýramy' => $this->islamicCalendar('01-10', $year),
            'Gurban baýramy 1-nji güni' => $this->islamicCalendar('10-12', $year),
            'Gurban baýramy 2-nji güni' => $this->islamicCalendar('11-12', $year),
            'Gurban baýramy 3-nji güni' => $this->islamicCalendar('12-12', $year),
        ];
    }

    protected function islamicCalendar(string $input, int $year, bool $nextYear = false): string
    {
        $hijriYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        $formatter = $this->getIslamicFormatter();

        $timeStamp = $formatter->parse($input.'/'.$hijriYear.' AH');
        $dateTime = date_create()->setTimeStamp($timeStamp)->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('m-d');
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

        return (int) $formatter->format($dateTime);
    }
}
