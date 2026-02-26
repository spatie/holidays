<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class NorthMacedonia extends Country
{
    public function countryCode(): string
    {
        return 'mk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Нова година', "{$year}-01-01"),
            Holiday::national('Божик, првиот ден на Божик според православниот календар', "{$year}-01-07"),
            Holiday::national('Ден на трудот', "{$year}-05-01"),
            Holiday::national('Св. Кирил и Методиј - Ден на сесловенските просветители', "{$year}-05-24"),
            Holiday::national('Ден на Републиката', "{$year}-08-02"),
            Holiday::national('Ден на независноста', "{$year}-09-08"),
            Holiday::national('Ден на народното востание', "{$year}-10-11"),
            Holiday::national('Ден на македонската револуционерна борба', "{$year}-10-23"),
            Holiday::national('Св. Климент Охридски', "{$year}-12-08"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Велигден, вториот ден на Велигден според православниот календар', $easter->addDay()),
        ];
    }
}
