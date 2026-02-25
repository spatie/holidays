<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Netherlands extends Country
{
    public function countryCode(): string
    {
        return 'nl';
    }

    protected function defaultLocale(): string
    {
        return 'nl';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nieuwjaarsdag' => CarbonImmutable::createFromDate($year, 1, 1),
            'Eerste kerstdag' => CarbonImmutable::createFromDate($year, 12, 25),
            'Tweede kerstdag' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
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
            $holidays['Bevrijdingsdag'] = CarbonImmutable::createFromDate($year, 5, 5);
        }

        return $holidays;
    }
}
