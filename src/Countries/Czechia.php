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
        // https://kalendar.beda.cz/statni-svatky-a-vyznamne-dny-v-roce-prehledne?year=1970
        $holidays = [
            'Nový rok' => ['01-01', $year <= 2000],
            'Nový rok; Den obnovy samostatného českého státu' => ['01-01', $year >= 2001],

            'Svátek práce' => ['05-01', true],

            'Výročí osvobození Československa Sovětskou armádou' => ['05-09', $year <= 1990],
            'Den osvobození od fašismu' => [$year === 1991 ? '05-09' : '05-08', $year >= 1991 && $year <= 2000],
            'Den osvobození' => ['05-08', $year >= 2001 && $year <= 2003],
            'Den vítězství' => ['05-08', $year >= 2004],

            'Den slovanských věrozvěstů Cyrila a Metoděje' => ['07-05', $year >= 1990],

            'Den upálení mistra Jana Husa' => ['07-06', $year >= 1990],

            'Den české státnosti' => ['09-28', $year >= 2000],

            'Vyhlášení samostatnosti ČSR; Schválení zákona o federaci' => ['10-28', $year <= 1971],
            'Den znárodnění' => ['10-28', $year === 1972],
            'Vyhlášení samostatnosti ČSR; Schválení zákona o federaci; Den znárodnění' => ['10-28', $year >= 1973 && $year <= 1974],
            'Den vzniku samostatného československého státu' => ['10-28', $year >= 1988],

            'Den boje za svobodu a demokracii a Mezinárodní den studentstva' => ['11-17', $year >= 2000],
            'Štědrý den' => ['12-24', $year >= 1990],
            '1. svátek vánoční' => ['12-25', true],
            '2. svátek vánoční' => ['12-26', true],
        ];

        $filteredHolidays = array_map(
            static fn (array $holiday) => $holiday[0],
            array_filter($holidays,
                static fn (array $holiday) => $holiday[1] === true
            )
        );

        return array_merge($filteredHolidays, $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $variableHolidays = [
            'Velikonoční pondělí' => [$easter->addDay(), true],
            'Velký pátek' => [$easter->subDays(2), $year >= 2016],
        ];

        return array_map(
            static fn (array $variableHoliday) => $variableHoliday[0],
            array_filter($variableHolidays,
                static fn (array $variableHoliday) => $variableHoliday[1] === true
            )
        );
    }
}
