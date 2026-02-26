<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Lithuania extends Country
{
    public function countryCode(): string
    {
        return 'lt';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Naujieji metai', "{$year}-01-01"),
            Holiday::national('Lietuvos valstybės atkūrimo diena', "{$year}-02-16"),
            Holiday::national('Nepriklausomybės atkūrimo diena', "{$year}-03-11"),
            Holiday::national('Tarptautinė darbo diena', "{$year}-05-01"),
            Holiday::national('Joninės', "{$year}-06-24"),
            Holiday::national('Karaliaus Mindaugo karūnavimo diena', "{$year}-07-06"),
            Holiday::national('Žolinė', "{$year}-08-15"),
            Holiday::national('Visų šventųjų diena', "{$year}-11-01"),
            Holiday::national('Vėlinės', "{$year}-11-02"),
            Holiday::national('Šv. Kūčios', "{$year}-12-24"),
            Holiday::national('Šv. Kalėdos', "{$year}-12-25"),
            Holiday::national('Šv. Kalėdų antroji diena', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Velykos', $easter),
            Holiday::national('Velykų antroji diena', $easter->addDay()),
        ];
    }
}
