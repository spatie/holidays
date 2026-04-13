<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Serbia extends Country
{
    public function countryCode(): string
    {
        return 'sr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nova godina - prvi dan', "{$year}-01-01"),
            Holiday::national('Nova godina - drugi dan', "{$year}-01-02"),
            Holiday::national('Božić', "{$year}-01-07"),
            Holiday::national('Dan državnosti - prvi dan', "{$year}-02-15"),
            Holiday::national('Dan državnosti - drugi dan', "{$year}-02-16"),
            Holiday::national('Praznik rada - prvi dan', "{$year}-05-01"),
            Holiday::national('Praznik rada - drugi dan', "{$year}-05-02"),
            Holiday::national('Dan primirja u Prvom svetskom ratu', "{$year}-11-11"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Veliki petak', $easter->subDays(2)),
            Holiday::national('Vaskrs', $easter),
            Holiday::national('Vaskršnji ponedeljak', $easter->addDay()),
        ];
    }
}
