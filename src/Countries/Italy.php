<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Italy extends Country
{
    public function countryCode(): string
    {
        return 'it';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Capodanno', "{$year}-01-01"),
            Holiday::national('Epifania', "{$year}-01-06"),
            Holiday::national('Festa della Liberazione', "{$year}-04-25"),
            Holiday::national('Festa dei Lavoratori', "{$year}-05-01"),
            Holiday::national('Festa della Repubblica', "{$year}-06-02"),
            Holiday::national('Assunzione di Maria', "{$year}-08-15"),
            ...$this->saintFrancis($year),
            Holiday::national('Ognissanti', "{$year}-11-01"),
            Holiday::national('Immacolata Concezione', "{$year}-12-08"),
            Holiday::national('Natale', "{$year}-12-25"),
            Holiday::national('Santo Stefano', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Lunedì di Pasqua', $easter->addDay()),
        ];
    }

    /** @return array<string, string> */
    protected function saintFrancis(int $year): array
    {
        if(($year >= 1939 && $year <= 1976) || $year >= 2026) {
            return [Holiday::national('San Francesco', "{$year}-10-04")];
        }

        return [];
    }
}
