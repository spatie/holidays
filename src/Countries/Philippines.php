<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Philippines extends Country
{
    public function countryCode(): string
    {
        return 'ph';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Araw ng Kagitingan', "{$year}-04-09"),
            Holiday::national('Labor Day', "{$year}-05-01"),
            Holiday::national('Independence Day', "{$year}-06-12"),
            Holiday::national('Bonifacio Day', "{$year}-11-27"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national('Rizal Day', "{$year}-12-30"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $nationalHeroes = new CarbonImmutable("last monday of august {$year}");

        $easter = $this->easter($year);

        return [
            Holiday::national('Maundy Thursday', $easter->subDays(3)),
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('National Heroes Day', $nationalHeroes),
        ];
    }
}
