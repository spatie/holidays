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
            'Naujieji metai' => CarbonImmutable::createFromDate($year, 1, 1),
            'Lietuvos valstybės atkūrimo diena' => CarbonImmutable::createFromDate($year, 2, 16),
            'Nepriklausomybės atkūrimo diena' => CarbonImmutable::createFromDate($year, 3, 11),
            'Tarptautinė darbo diena' => CarbonImmutable::createFromDate($year, 5, 1),
            'Joninės' => CarbonImmutable::createFromDate($year, 6, 24),
            'Karaliaus Mindaugo karūnavimo diena' => CarbonImmutable::createFromDate($year, 7, 6),
            'Žolinė' => CarbonImmutable::createFromDate($year, 8, 15),
            'Visų šventųjų diena' => CarbonImmutable::createFromDate($year, 11, 1),
            'Vėlinės' => CarbonImmutable::createFromDate($year, 11, 2),
            'Šv. Kūčios' => CarbonImmutable::createFromDate($year, 12, 24),
            'Šv. Kalėdos' => CarbonImmutable::createFromDate($year, 12, 25),
            'Šv. Kalėdų antroji diena' => CarbonImmutable::createFromDate($year, 12, 26),
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
