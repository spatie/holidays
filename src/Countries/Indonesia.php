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
            'Tahun Baru' => '01-01',
            'Hari Buruh Internasional' => '05-01',
            'Hari Lahir Pancasila' => '06-01',
            'Hari Kemerdekaan' => '08-17',
            'Hari Raya Natal' => '12-25',
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
