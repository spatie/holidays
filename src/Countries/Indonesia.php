<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Indonesia extends Country
{
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
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Jakarta');

        return [
            'Jumat Agung' => $easter->subDays(1),
            'Hari Paskah' => $easter->addDays(1),
            'Kenaikan Yesus Kristus' => $easter->addDays(40),
        ];
    }
}
