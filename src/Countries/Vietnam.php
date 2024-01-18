<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Vietnam extends Country
{
    public function countryCode(): string
    {
        return 'vi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s day' => '01-01',
            'Reunification Day' => '04-30',
            'Labour Day' => '05-01',
            'Independence Day' => '09-02',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
