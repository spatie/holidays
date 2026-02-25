<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Malawi extends Country
{
    public function countryCode(): string
    {
        return 'mw';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Years  Day' => CarbonImmutable::createFromDate($year, 1, 1),
            'John Chilembwe Day' => CarbonImmutable::createFromDate($year, 1, 15),
            'Martyrs Day' => CarbonImmutable::createFromDate($year, 3, 3),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Kamuzu Day' => CarbonImmutable::createFromDate($year, 5, 14),
            'Independence Day' => CarbonImmutable::createFromDate($year, 7, 6),
            'Mothers Day' => CarbonImmutable::createFromDate($year, 10, 15),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    private function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
