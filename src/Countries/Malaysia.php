<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;

class Malaysia extends Country
{
    protected string $timezone = 'Asia/Kuala_Lumpur';

    public function countryCode(): string
    {
        return 'ms';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Tahun Baru' => '01-01',
            'Hari Pekerja' => '05-01',
            'Hari Kebangsaan' => '08-31',
            'Hari Malaysia' => '09-16',
            'Hari Krismas' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Tahun Baru Cina' => $this->chineseCalendar('01/01', $year),
            'Tahun Baru Cina Hari Kedua' => $this->chineseCalendar('01/02', $year),
            'Hari Raya Aidilfitri' => $this->islamicCalendar('01/10', $year),
            'Hari Raya Aidilfitri Hari Kedua' => $this->islamicCalendar('02/10', $year),
            'Hari Raya Haji' => $this->islamicCalendar('10/12', $year),
            'Hari Raya Haji Hari Kedua' => $this->islamicCalendar('11/12', $year),
            'Maulidur Rasul' => $this->islamicCalendar('12/03', $year, true),
            'Awal Muharram' => $this->islamicCalendar('01/01', $year, true),
        ];
    }

    protected function chineseCalendar(string $input, int $year): string
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-CN@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );

        $timeStamp = $formatter->parse($year . '/' . $input);
        $dateTime = date_create()->setTimeStamp($timeStamp)->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('m-d');
    }

    protected function islamicCalendar(string $input, int $year, $nextYear = false): string
    {
        $hijrYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        $formatter = $this->getIslamicFormatter();

        $timeStamp = $formatter->parse($input . '/' . $hijrYear . ' AH');
        $dateTime = date_create()->setTimeStamp($timeStamp)->setTimezone(new DateTimeZone('Asia/Kuala_Lumpur'));

        return $dateTime->format('m-d');
    }

    protected function getIslamicFormatter()
    {
        return new IntlDateFormatter(
            locale: 'ms_MY@calendar=islamic-civil',
            dateType: IntlDateFormatter::MEDIUM,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }

    protected function getHijriYear(int $year, $nextYear = false): int
    {
        $formatter = $this->getIslamicFormatter();
        $formatter->setPattern('yyyy');
        $dateTime = DateTime::createFromFormat('d/m/Y', '01/01/' . ($nextYear ? $year + 1 : $year));

        return (int) $formatter->format($dateTime);
    }
}
