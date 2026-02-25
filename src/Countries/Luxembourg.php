<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Luxembourg extends Country
{
    public function countryCode(): string
    {
        return 'lu';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Neijoerschdag' => CarbonImmutable::createFromDate($year, 1, 1),
            'Dag vun der Aarbecht' => CarbonImmutable::createFromDate($year, 5, 1),
            'Europadag' => CarbonImmutable::createFromDate($year, 5, 9),
            'Nationalfeierdag' => CarbonImmutable::createFromDate($year, 6, 23),
            'Mariä Himmelfahrt' => CarbonImmutable::createFromDate($year, 8, 15),
            'Allerhellgen' => CarbonImmutable::createFromDate($year, 11, 1),
            'Chrëschtdag' => CarbonImmutable::createFromDate($year, 12, 25),
            'Stiefesdag' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Ouschterméindeg' => $easter->addDay(),
            'Christi Himmelfahrt' => $easter->addDays(39),
            'Péngschtméindeg' => $easter->addDays(50),
        ];
    }
}
