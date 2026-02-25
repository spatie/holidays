<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Estonia extends Country
{
    public function countryCode(): string
    {
        return 'ee';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Uusaasta' => CarbonImmutable::createFromDate($year, 1, 1),
            'Iseseisvuspäev' => CarbonImmutable::createFromDate($year, 2, 24),
            'Kevadpüha' => CarbonImmutable::createFromDate($year, 5, 1),
            'Võidupüha' => CarbonImmutable::createFromDate($year, 6, 23),
            'Jaanipäev' => CarbonImmutable::createFromDate($year, 6, 24),
            'Taasiseseisvumispäev' => CarbonImmutable::createFromDate($year, 8, 20),
            'Jõululaupäev' => CarbonImmutable::createFromDate($year, 12, 24),
            'Esimene jõulupüha' => CarbonImmutable::createFromDate($year, 12, 25),
            'Teine jõulupüha' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Suur reede' => $easter->subDays(2),
            'Ülestõusmispühade 1. püha' => $easter,
            'Nelipühade 1. püha' => $easter->addDays(49),
        ];
    }
}
