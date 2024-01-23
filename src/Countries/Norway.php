<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Norway extends Country
{
    public function countryCode(): string
    {
        return 'no';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Første nyttårsdag' => '01-01',
            'Arbeidernes dag' => '05-01',
            'Grunnlovsdag' => '05-17',
            'Første juledag' => '12-25',
            'Andre juledag' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Oslo');

        $holidays = [
            'Skjærtorsdag' => $easter->subDays(3),
            'Langfredag' => $easter->subDays(2),
            'Første påskedag' => $easter,
            'Andre påskedag,' => $easter->addDay(),
            'Kristi Himmelfartsdag' => $easter->addDays(39),
            'Første pinsedag' => $easter->addDays(49),
            'Andre pinsedag' => $easter->addDays(50),
        ];

        return $holidays;
    }
}
