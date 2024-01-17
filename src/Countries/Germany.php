<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Germany extends Country
{
    public function countryCode(): string
    {
        return 'de';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Neujahr' => '01-01',
            'Tag der deutschen Einheit' => '10-03',
            'Tag der Arbeit' => '05-01',
            '1. Weihnachtstag' => '12-25',
            '2. Weihnachtstag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Berlin');

        return [
            'Karfreitag' => $easter->subDays(2),
            'Ostermontag' => $easter->addDay(),
            'Himmelfahrt' => $easter->addDays(39),
            'Pfingstmontag' => $easter->addDays(50),
        ];
    }
}
