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
            'Neijoerschdag' => '01-01',
            'Dag vun der Aarbecht' => '05-01',
            'Europadag' => '05-09',
            'Nationalfeierdag' => '06-23',
            'Mariä Himmelfahrt' => '08-15',
            'Allerhellgen' => '11-01',
            'Chrëschtdag' => '12-25',
            'Stiefesdag' => '12-26',
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
