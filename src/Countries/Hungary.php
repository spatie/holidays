<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Hungary extends Country
{
    public function countryCode(): string
    {
        return 'hu';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Újév', "{$year}-01-01"),
            Holiday::national('1848-as forradalom évfordulója', "{$year}-03-15"),
            Holiday::national('A munka ünnepe', "{$year}-05-01"),
            Holiday::national('Államalapítás ünnepe', "{$year}-08-20"),
            Holiday::national('1956-os forradalom évfordulója', "{$year}-10-23"),
            Holiday::national('Mindenszentek', "{$year}-11-01"),
            Holiday::national('Karácsony', "{$year}-12-25"),
            Holiday::national('Karácsony másnapja', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Nagypéntek', $easter->subDays(2)),
            Holiday::national('Húsvéthétfő', $easter->addDay()),
            Holiday::national('Pünkösdhétfő', $easter->addDays(50)),
        ];
    }
}
