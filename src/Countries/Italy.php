<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Italy extends Country
{
    public function countryCode(): string
    {
        return 'it';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Capodanno' => '01-01',
            'Epifania' => '01-06',
            'Festa della Liberazione' => '04-25',
            'Festa dei Lavoratori' => '05-01',
            'Festa della Repubblica' => '06-02',
            'Assunzione di Maria' => '08-15',
            'Ognissanti' => '11-01',
            'Immacolata Concezione' => '12-08',
            'Natale' => '12-25',
            'Santo Stefano' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Lunedì di Pasqua' => $easter->addDay(),
        ];
    }
}
