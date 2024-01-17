<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Hungary extends Country
{
    public function countryCode(): string
    {
        return 'hu';
    }

    public function get(int $year): array
    {
        $this->ensureYearCanBeCalculated($year);

        $fixedHolidays = $this->fixedHolidays($year);
        $variableHolidays = $this->variableHolidays($year);

        return array_merge($fixedHolidays, $variableHolidays);
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        $dates = [
            'Újév' => '01-01',
            '1848-as forradalom évfordulója' => '15-03',
            'A munka ünnepe' => '01-05',
            'Államalapítás ünnepe' => '20-08',
            '1956-os forradalom évfordulója' => '23-10',
            'Mindenszentek' => '01-11',
            'Karácsony' => '25-12',
            'Karácsony másnapja' => '26-12',
        ];

        foreach ($dates as $name => $date) {
            $dates[$name] = CarbonImmutable::createFromFormat('d-m-Y', "{$date}-{$year}");
        }

        return $dates;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Brussels');

        return [
            'Nagypéntek' => $easter->subDays(2),
            'Húsvéthétfő' => $easter->addDay(),
            'Pünkösdhétfő' => $easter->addDays(50),
        ];
    }
}
