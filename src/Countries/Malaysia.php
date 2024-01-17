<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Malaysia extends Country
{

    public function countryCode(): string
    {
        return 'my';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Tahun Baru' => '01-01',
            'Hari Wilayah Persekutuan' => '02-01',
            'Hari Perisytiharan Melaka Sebagai Bandaraya Bersejarah' => '04-15',
            'Hari Pekerja' => '05-01',
            'Hari Hol Pahang' => '05-22',
            'Pesta Keamatan' => '05-30',
            'Hari Sarawak' => '07-22',
            'Hari Kebangsaan' => '08-31',
            'Hari Malaysia' => '09-16',
            'Hari Krismas' => '12-25',
        ], $this->variableHolidays($year));
    }

    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Kuala_Lumpur');

        return [
            'Good Friday' => $easter->subDays(2),
        ];
    }
}
