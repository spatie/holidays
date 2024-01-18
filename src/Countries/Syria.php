<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Syria extends Country
{
    public function countryCode(): string
    {
        return 'sy';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Mother\'s Day' => '03-21',
            'Independence Day' => '04-17',
            'Labor' => '05-01',
            'Martyrs\' Day' => '05-06',
            'Anniversary of the October War' => '10-06',
            'Christmas' => '12-25',

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Damascus');

        return [
            'Western Easter' => $easter->addDay(0),
            'Eastern Easter' => $easter->addDays(35),
        ];
    }
}
