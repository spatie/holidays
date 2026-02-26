<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Estonia extends Country
{
    public function countryCode(): string
    {
        return 'ee';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Uusaasta', "{$year}-01-01"),
            Holiday::national('Iseseisvuspäev', "{$year}-02-24"),
            Holiday::national('Kevadpüha', "{$year}-05-01"),
            Holiday::national('Võidupüha', "{$year}-06-23"),
            Holiday::national('Jaanipäev', "{$year}-06-24"),
            Holiday::national('Taasiseseisvumispäev', "{$year}-08-20"),
            Holiday::national('Jõululaupäev', "{$year}-12-24"),
            Holiday::national('Esimene jõulupüha', "{$year}-12-25"),
            Holiday::national('Teine jõulupüha', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Suur reede', $easter->subDays(2)),
            Holiday::national('Ülestõusmispühade 1. püha', $easter),
            Holiday::national('Nelipühade 1. püha', $easter->addDays(49)),
        ];
    }
}
