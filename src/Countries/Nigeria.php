<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Nigeria extends Country
{
    public function countryCode(): string
    {
        return 'ng';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Worker\'s Day' => '05-01',
            'Democracy Day' => '06-12',
            'Independence Day' => '10-01',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
