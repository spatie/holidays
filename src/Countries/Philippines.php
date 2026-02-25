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
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Araw ng Kagitingan' => CarbonImmutable::createFromDate($year, 4, 9),
            'Labor Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Independence Day' => CarbonImmutable::createFromDate($year, 6, 12),
            'Bonifacio Day' => CarbonImmutable::createFromDate($year, 11, 27),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Rizal Day' => CarbonImmutable::createFromDate($year, 12, 30),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
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
