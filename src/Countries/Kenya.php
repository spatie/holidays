<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Kenya extends Country
{
    public function countryCode(): string
    {
        return 'ke';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's" => '01-01',
            'Labour' => '05-01',
            'Madaraka' => '06-01',
            'Utamaduni' => '10-10',
            'Mashujaa' => '10-20',
            'Jamhuri' => '12-01',
            'Christmas' => '12-25',
            'Boxing' => '12-26',
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
