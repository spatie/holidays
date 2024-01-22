<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Canada extends Country
{
    public function countryCode(): string
    {
        return 'ca';
    }

    // These 5 statutory holidays are the only constant among all provinces
    // All other holidays vary from province to province.

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Canada Day' => '07-01',
            'Christmas Day' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $labourDay = new CarbonImmutable("first monday of september {$year}");

        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Labour Day' => $labourDay,
        ];
    }
}
