<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Lithuania extends Country
{
    public function countryCode(): string
    {
        return 'lt';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Naujieji metai' => '01-01',
            'Lietuvos valstybės atkūrimo diena' => '02-16',
            'Nepriklausomybės atkūrimo diena' => '03-11',
            'Tarptautinė darbo diena' => '05-01',
            'Joninės' => '06-24',
            'Karaliaus Mindaugo karūnavimo diena' => '07-06',
            'Žolinė' => '08-15',
            'Visų šventųjų diena' => '11-01',
            'Vėlinės' => '11-02',
            'Šv. Kūčios' => '12-24',
            'Šv. Kalėdos' => '12-25',
            'Šv. Kalėdų antroji diena' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Velykos' => $easter,
            'Velykų antroji diena' => $easter->addDay(),
        ];
    }
}
