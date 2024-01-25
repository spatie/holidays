<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Jamaica extends Country
{
    public function countryCode(): string
    {
        return 'jm';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = array_merge([
            'New Year\'s Day' => '01-01',
            'Labour Day' => '05-23',
            'Emancipation Day' => '08-01',
            'Independence Day' => '08-06',
            'National Heroes Day' => '10-18',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {

        $easter = $this->easter($year);

        return [
            'Ash Wednesday' => $easter->subDays(46),
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
