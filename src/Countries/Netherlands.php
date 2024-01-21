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
            '1e Kerstdag' => '12-25',
            '2e Kerstdag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $koningsDag = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-04-27");

        if ($koningsDag->isSunday()) {
            $koningsDag = $koningsDag->subDay();
        }

        $easter = $this->easter($year);

        return [
            'Koningsdag' => $koningsDag,
            'Goede Vrijdag' => $easter->subDays(2),
            '1e Paasdag' => $easter,
            '2e Paasdag' => $easter->addDay(),
            'Hemelvaartsdag' => $easter->addDays(39),
            '1e Pinksterdag' => $easter->addDays(49),
            '2e Pinksterdag' => $easter->addDays(50),
        ];
    }
}
