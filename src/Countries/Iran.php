<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Iran extends Country
{
    public function countryCode(): string
    {
        return 'ir';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Islamic Revolution Day' => '02-11',
            'Nationalization of Oil Industry Day' => '03-19',
            'Nowruz First Day' => '03-20',
            'Nowruz Second Day' => '03-21',
            'Nowruz Third Day' => '03-22',
            'Nowruz Fourth Day' => '03-23',
            'Islamic Republic Day' => '03-31',
            'Nature Day' => '04-01',
            'Death of Khomeini Day' => '06-03',
            'Revolt of Khordad 15 Day' => '06-04',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Tehran');

        return [
            //add more holidays
        ];
    }
}