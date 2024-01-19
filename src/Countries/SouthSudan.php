<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class SouthSudan extends Country
{
    public function countryCode(): string
    {
        return 'ss';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's  Day" => '01-01',
            'Peace Agreement Day' => '01-09',
            "International Women's Day" => '03-08',
            'Labour Day' => '05-01',
            'SPLA Day' => '05-16',
            "Martyrs' Day" => '07-30',
            'Independence Day' => '07-09',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
            'Republic Day' => '12-28',
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
