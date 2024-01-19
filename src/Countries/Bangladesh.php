<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Bangladesh extends Country
{
    public function countryCode(): string
    {
        return 'bd';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'International Mother Language Day' => '02-21',
            'Sheikh Mujibur Rahman\'s Birthday' => '03-17',
            'Independence Day' => '03-26',
            'Bengali New Year\'s Day' => '04-14',
            'May Day' => '05-01',
            'National Day of Mourning' => '08-15',
            'Victory Day' => '12-16',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Dhaka');

        return [
            'Lunedì di Pasqua' => $easter->addDay(),
        ];
    }
}
