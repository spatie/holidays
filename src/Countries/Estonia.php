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
            'Uusaasta' => '01-01',
            'Iseseisvuspäev' => '02-24',
            'Kevadpüha' => '05-01',
            'Võidupüha' => '06-23',
            'Jaanipäev' => '06-24',
            'Taasiseseisvumispäev' => '08-20',
            'Jõululaupäev' => '12-24',
            'Esimene jõulupüha' => '12-25',
            'Teine jõulupüha' => '12-26',
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
