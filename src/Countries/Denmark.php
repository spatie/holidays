<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Denmark extends Country
{
    public function countryCode(): string
    {
        return 'da';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nytår' => '01-01',
            'Juleaften' => '24-12',
            'Juledag' => '25-12',
            'Anden Juledag' => '26-12'
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Copenhagen');

        return [
            'Påskedag' => $easter->addDay(),
            'Skærtorsdag' => $easter->subDays(3),
            'Langfredag' => $easter->subDays(2),
            'Anden Påskedag' => $easter->addDays(2),
            'Kristi Himmelfartsdag' => $easter->addDays(39),
            'Pinse' => $easter->addDays(49),
            'Anden Pinsedag' => $easter->addDays(50),
        ];
    }
}
