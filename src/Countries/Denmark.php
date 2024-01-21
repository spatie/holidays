<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Denmark extends Country
{
    public function countryCode(): string
    {
        return 'da';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nytår' => '01-01',
            'Juleaften' => '12-24',
            'Juledag' => '12-25',
            'Anden Juledag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $holidays = [
            'Påskedag' => $easter->addDay(),
            'Skærtorsdag' => $easter->subDays(3),
            'Langfredag' => $easter->subDays(2),
            'Anden Påskedag' => $easter->addDays(2),
            'Kristi Himmelfartsdag' => $easter->addDays(39),
            'Pinse' => $easter->addDays(49),
            'Anden Pinsedag' => $easter->addDays(50),
        ];

        if ($year < 2024) {
            $holidays['Store Bededag'] = $easter->addDays(26);
        }

        return $holidays;
    }
}
