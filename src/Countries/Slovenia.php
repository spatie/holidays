<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Slovenia extends Country
{
    public function countryCode(): string
    {
        return 'si';
    }

    protected function allHolidays(int $year): array
    {

        return array_merge([
            Holiday::national('Novo leto', "{$year}-01-01"),
            Holiday::national('Novo leto 2', "{$year}-01-02"),
            Holiday::national('Prešernov dan, slovenski kulturni praznik', "{$year}-02-08"),
            Holiday::national('Dan upora proti okupatorju', "{$year}-04-27"),
            Holiday::national('Praznik dela', "{$year}-05-01"),
            Holiday::national('Praznik dela 2', "{$year}-05-02"),
            Holiday::national('Dan državnosti', "{$year}-06-25"),
            Holiday::national('Marijino vnebovzetje', "{$year}-08-15"),
            Holiday::national('Dan reformacije', "{$year}-10-31"),
            Holiday::national('Dan spomina na mrtve', "{$year}-11-01"),
            Holiday::national('Božič', "{$year}-12-25"),
            Holiday::national('Dan samostojnosti in enotnosti', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Velikonočna nedelja', $easter),
            Holiday::national('Velikonočni ponedeljek', $easter->addDay()),
            Holiday::national('Binkoštna nedelja', $easter->addDays(49)),
        ];
    }
}
