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
            'New Years  Day' => '01-01',
            'John Chilembwe Day' => '01-15',
            'Martyrs Day' => '03-03',
            'Labour Day' => '05-01',
            'Kamuzu Day' => '05-14',
            'Independence Day' => '07-06',
            'Mothers Day' => '10-15',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
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
