<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Serbia extends Country
{
    public function countryCode(): string
    {
        return 'sr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nova godina - prvi dan' => CarbonImmutable::createFromDate($year, 1, 1),
            'Nova godina - drugi dan' => CarbonImmutable::createFromDate($year, 1, 2),
            'Božić' => CarbonImmutable::createFromDate($year, 1, 7),
            'Dan državnosti - prvi dan' => CarbonImmutable::createFromDate($year, 2, 15),
            'Dan državnosti - drugi dan' => CarbonImmutable::createFromDate($year, 2, 16),
            'Praznik rada - prvi dan' => CarbonImmutable::createFromDate($year, 5, 1),
            'Praznik rada - drugi dan' => CarbonImmutable::createFromDate($year, 5, 2),
            'Dan primirja u Prvom svetskom ratu' => CarbonImmutable::createFromDate($year, 11, 11),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            'Veliki petak' => $easter->subDays(2),
            'Vaskrs' => $easter,
            'Vaskršnji ponedeljak' => $easter->addDay(),
        ];
    }
}
