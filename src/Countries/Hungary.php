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
            'Újév' => '01-01',
            '1848-as forradalom évfordulója' => '03-15',
            'A munka ünnepe' => '05-01',
            'Államalapítás ünnepe' => '08-20',
            '1956-os forradalom évfordulója' => '10-23',
            'Mindenszentek' => '11-01',
            'Karácsony' => '12-25',
            'Karácsony másnapja' => '12-26',
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
