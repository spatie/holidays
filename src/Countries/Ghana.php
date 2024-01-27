<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ghana extends Country
{

    public function countryCode(): string
    {
        return 'gh';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Constitution Day' => '01-07',
            'Independence Day' => '03-06',
            'May Day' => '05-01',
            'Founder\'s Day' => '08-04',
            'Kwame Nkrumah Memorial Day' => '09-21',
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
