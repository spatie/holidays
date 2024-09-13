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
            'Hari Pekerja' => '05-01',
            'Hari Kebangsaan' => '08-31',
            'Hari Malaysia' => '09-16',
            'Hari Keputeraan YDP Agong' => CarbonImmutable::parse("First Monday of June $year")->setTimezone('Asia/Kuala_Lumpur'),
            'Hari Krismas' => '12-25',

        ], $this->variableHolidays($year));
    }

    protected function variableHolidays(int $year): array
    {
        return [
            'Hari Keputeraan Yang Di-Pertuan Besar Negeri Sembilan' => '01-14',
            'Hari Wilayah Persekutuan' => '02-01',
            'Hari Ulang Tahun Pertabalan Sultan Terengganu' => '03-04',
            'Hari Keputeraan Sultan Johor' => '03-23',
            'Hari Keputeraan Sultan Terengganu' => '04-26',
            'Hari Keputeraan Raja Perlis' => '05-17',
            'Hari Keputeraan Sultan Kedah' => CarbonImmutable::parse("Third Sunday of June $year")->setTimezone('Asia/Kuala_Lumpur'),
            'Harijadi Yang di-Pertua Negeri Pulau Pinang' => CarbonImmutable::parse("Second Saturday of July $year")->setTimezone('Asia/Kuala_Lumpur'),
            'Hari Keputeraan Sultan Pahang' => '07-30',
            'Harijadi Yang di-Pertua Negeri Melaka' => '08-24',
            'Hari Keputeraan Sultan Kelantan' => '09-29',
            'Harijadi Yang di-Pertua Negeri Sabah' => CarbonImmutable::parse("First Saturday of October $year")->setTimezone('Asia/Kuala_Lumpur'),
            'Harijadi Yang di-Pertua Negeri Sarawak' => CarbonImmutable::parse("Second Saturday of October $year")->setTimezone('Asia/Kuala_Lumpur'),
            'Hari Keputeraan Sultan Perak' => CarbonImmutable::parse("First Friday of November $year")->setTimezone('Asia/Kuala_Lumpur'),
            'Hari Keputeraan Sultan Selangor' => '12-11'
        ];
    }
}
