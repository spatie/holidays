<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Calendars\ChineseCalendar;

class Vietnam extends Country
{
    use ChineseCalendar;

    public function countryCode(): string
    {
        return 'vi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s day' => '01-01',
            'Reunification Day' => '04-30',
            'Labour Day' => '05-01',
            'Independence Day' => '09-02',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Lunar New Year\'s Eve' => $this->chineseToGregorianDate('01/01', $year),
            'Lunar New Year Day 1' => $this->chineseToGregorianDate('01/01', $year),
            'Lunar New Year Day 2' => $this->chineseToGregorianDate('01/02', $year),
            'Lunar New Year Day 3' => $this->chineseToGregorianDate('01/03', $year),
            'Lunar New Year Day 4' => $this->chineseToGregorianDate('01/04', $year),
            'Hung Kings\' Festival' => $this->chineseToGregorianDate('03/10', $year),
        ];
    }
}
