<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Hungary extends Country
{
    public function countryCode(): string
    {
        return 'hu';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Újév' => CarbonImmutable::createFromDate($year, 1, 1),
            '1848-as forradalom évfordulója' => CarbonImmutable::createFromDate($year, 3, 15),
            'A munka ünnepe' => CarbonImmutable::createFromDate($year, 5, 1),
            'Államalapítás ünnepe' => CarbonImmutable::createFromDate($year, 8, 20),
            '1956-os forradalom évfordulója' => CarbonImmutable::createFromDate($year, 10, 23),
            'Mindenszentek' => CarbonImmutable::createFromDate($year, 11, 1),
            'Karácsony' => CarbonImmutable::createFromDate($year, 12, 25),
            'Karácsony másnapja' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Nagypéntek' => $easter->subDays(2),
            'Húsvéthétfő' => $easter->addDay(),
            'Pünkösdhétfő' => $easter->addDays(50),
        ];
    }
}
