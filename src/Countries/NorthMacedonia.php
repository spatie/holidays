<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class NorthMacedonia extends Country
{
    public function countryCode(): string
    {
        return 'mk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Нова година' => CarbonImmutable::createFromDate($year, 1, 1),
            'Божик, првиот ден на Божик според православниот календар' => CarbonImmutable::createFromDate($year, 1, 7),
            'Ден на трудот' => CarbonImmutable::createFromDate($year, 5, 1),
            'Св. Кирил и Методиј - Ден на сесловенските просветители' => CarbonImmutable::createFromDate($year, 5, 24),
            'Ден на Републиката' => CarbonImmutable::createFromDate($year, 8, 2),
            'Ден на независноста' => CarbonImmutable::createFromDate($year, 9, 8),
            'Ден на народното востание' => CarbonImmutable::createFromDate($year, 10, 11),
            'Ден на македонската револуционерна борба' => CarbonImmutable::createFromDate($year, 10, 23),
            'Св. Климент Охридски' => CarbonImmutable::createFromDate($year, 12, 8),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            'Велигден, вториот ден на Велигден според православниот календар' => $easter->addDay(),
        ];
    }
}
