<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Jordan extends Country
{
    public function countryCode(): string
    {
        return 'jo';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Labor' => '05-01',
            'Independence Day' => '05-25',
            'Christmas Day' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))->setTimezone('Asia/Amman');

        return [];
    }
}
