<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Philippines extends Country
{
    public function countryCode(): string
    {
        return 'ph';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Araw ng Kagitingan' => '04-09',
            'Labor Day' => '05-01',
            'Independence Day' => '06-12',
            'Bonifacio Day' => '11-27',
            'Christmas Day' => '12-25',
            'Rizal Day' => '12-30',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $nationalHeroes = new CarbonImmutable("last monday of august {$year}");

        $easter = $this->easter($year);

        return [
            'Maundy Thursday' => $easter->subDays(3),
            'Good Friday' => $easter->subDays(2),
            'National Heroes Day' => $nationalHeroes,
        ];
    }
}
