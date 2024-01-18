<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Uzbekistan extends Country
{
    public function countryCode(): string
    {
        return 'uz';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Yangi yil' => '01-01',
            'Xalqaro xotin-qizlar kuni' => '03-08',
            'Navro\'z' => '03-21',
            'Xotira va qadrlash kuni' => '05-09',
            'Mustaqillik kuni' => '09-01',
            'Ustoz va murabbiylar kuni' => '10-01',
            'Konstitutsiya kuni' => '12-08',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Tashkent');

        return [
            //'Ramazon Hayiti' (Eid al-Fitr) and 'Qurbon Hayiti' (Eid al-Adha) will be added after the implementation of Islamic holidays
        ];
    }
}
