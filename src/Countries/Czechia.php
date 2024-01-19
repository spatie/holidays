<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Czechia extends Country
{
    public function countryCode(): string
    {
        return 'cz';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Den obnovy samostatného českého státu' => '01-01',
            'Svátek práce' => '05-01',
            'Den vítězství' => '05-08',
            'Den slovanských věrozvěstů Cyrila a Metoděje' => '07-05',
            'Den upálení mistra Jana Husa' => '07-06',
            'Den české státnosti' => '09-28',
            'Den vzniku samostatného československého státu' => '10-28',
            'Den boje za svobodu a demokracii a Mezinárodní den studentstva' => '11-17',
            'Štědrý den' => '12-24',
            '1. svátek vánoční' => '12-25',
            '2. svátek vánoční' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Velikonoční pondělí' => $easter->addDay(),
            'Velký pátek' => $easter->subDays(2),
        ];
    }
}
