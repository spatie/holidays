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
            'Bevrijdingsdag' => '05-05',
            'Eerste kerstdag' => '12-25',
            'Tweede kerstdag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        /** @var CarbonImmutable $koningsDag */
        $koningsDag = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-04-27");

        if ($koningsDag->isSunday()) {
            $koningsDag = $koningsDag->subDay();
        }

        $easter = $this->easter($year);

        return [
            'Koningsdag' => $koningsDag,
            'Goede Vrijdag' => $easter->subDays(2),
            'Eerste paasdag' => $easter,
            'Tweede paasdag' => $easter->addDay(),
            'Hemelvaartsdag' => $easter->addDays(39),
            'Eerste pinksterdag' => $easter->addDays(49),
            'Tweede pinksterdag' => $easter->addDays(50),
        ];
    }
}
