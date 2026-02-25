<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Uganda extends Country
{
    public function countryCode(): string
    {
        return 'ug';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's  Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'NRM Liberation Day' => CarbonImmutable::createFromDate($year, 1, 26),
            'Archbishop Janani Luwum Day' => CarbonImmutable::createFromDate($year, 2, 16),
            "International Women's Day" => CarbonImmutable::createFromDate($year, 3, 8),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            "Martyrs' Day" => CarbonImmutable::createFromDate($year, 6, 3),
            'National Hereos Day' => CarbonImmutable::createFromDate($year, 6, 9),
            'Independence Day' => CarbonImmutable::createFromDate($year, 10, 9),
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
