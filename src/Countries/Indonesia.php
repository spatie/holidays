<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Calendars\ChineseCalendar;

class Indonesia extends Country
{
    use ChineseCalendar;

    public function countryCode(): string
    {
        return 'id';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Buruh Internasional' => CarbonImmutable::createFromDate($year, 5, 1),
            'Hari Lahir Pancasila' => CarbonImmutable::createFromDate($year, 6, 1),
            'Hari Kemerdekaan' => CarbonImmutable::createFromDate($year, 8, 17),
            'Hari Raya Natal' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Tahun Baru Imlek' => $this->chineseToGregorianDate('01-01', $year),
            'Jumat Agung' => $easter->subDays(2),
            'Hari Paskah' => $easter,
            'Kenaikan Yesus Kristus' => $easter->addDays(39),
        ];
    }
}
