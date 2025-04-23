<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Netherlands extends Country
{
    public function countryCode(): string
    {
        return 'nl';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nieuwjaarsdag' => '01-01',
            'Eerste kerstdag' => '12-25',
            'Tweede kerstdag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $koningsDag = CarbonImmutable::createFromDate($year, 4, 27);

        if ($koningsDag->isSunday()) {
            $koningsDag = $koningsDag->subDay();
        }

        $easter = $this->easter($year);

        $holidays = [
            'Koningsdag' => $koningsDag,
            'Eerste paasdag' => $easter,
            'Tweede paasdag' => $easter->addDay(),
            'Hemelvaartsdag' => $easter->addDays(39),
            'Eerste pinksterdag' => $easter->addDays(49),
            'Tweede pinksterdag' => $easter->addDays(50),
        ];

        if ($year % 5 === 0) {
            $holidays['Bevrijdingsdag'] = '05-05';
        }

        return $holidays;
    }
}
