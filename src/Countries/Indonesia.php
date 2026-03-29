<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Holiday;

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
            Holiday::national('Tahun Baru', "{$year}-01-01"),
            Holiday::national('Hari Buruh Internasional', "{$year}-05-01"),
            Holiday::national('Hari Lahir Pancasila', "{$year}-06-01"),
            Holiday::national('Hari Kemerdekaan', "{$year}-08-17"),
            Holiday::national('Hari Raya Natal', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Tahun Baru Imlek', $this->chineseToGregorianDate('01-01', $year)),
            Holiday::national('Jumat Agung', $easter->subDays(2)),
            Holiday::national('Hari Paskah', $easter),
            Holiday::national('Kenaikan Yesus Kristus', $easter->addDays(39)),
        ];
    }
}
