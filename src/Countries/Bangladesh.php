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
            'International Mother Language Day' => '21-02',
            'Mujib\'s Birthday & Children\'s Day' => '17-03',
            'Independence Day' => '26-03',
            'Bengali New Year' => '14-04',
            'May Day' => '01-05',
            'National Day of Mourning' => '15-08',
            'Victory Day' => '16-12',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Dhaka');

        // Bangladesh doesn't have variable holidays based on Easter.
        // If there are any specific variable holidays for Bangladesh, you can add them here.
        return [];
    }
}
