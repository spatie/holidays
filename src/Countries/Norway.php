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
            'Første nyttårsdag' => CarbonImmutable::createFromDate($year, 1, 1),
            'Arbeidernes dag' => CarbonImmutable::createFromDate($year, 5, 1),
            'Grunnlovsdag' => CarbonImmutable::createFromDate($year, 5, 17),
            'Første juledag' => CarbonImmutable::createFromDate($year, 12, 25),
            'Andre juledag' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Skjærtorsdag' => $easter->subDays(3),
            'Langfredag' => $easter->subDays(2),
            'Første påskedag' => $easter,
            'Andre påskedag,' => $easter->addDay(),
            'Kristi Himmelfartsdag' => $easter->addDays(39),
            'Første pinsedag' => $easter->addDays(49),
            'Andre pinsedag' => $easter->addDays(50),
        ];
    }
}
