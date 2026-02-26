<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Norway extends Country
{
    public function countryCode(): string
    {
        return 'no';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Første nyttårsdag', "{$year}-01-01"),
            Holiday::national('Arbeidernes dag', "{$year}-05-01"),
            Holiday::national('Grunnlovsdag', "{$year}-05-17"),
            Holiday::national('Første juledag', "{$year}-12-25"),
            Holiday::national('Andre juledag', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Skjærtorsdag', $easter->subDays(3)),
            Holiday::national('Langfredag', $easter->subDays(2)),
            Holiday::national('Første påskedag', $easter),
            Holiday::national('Andre påskedag,', $easter->addDay()),
            Holiday::national('Kristi Himmelfartsdag', $easter->addDays(39)),
            Holiday::national('Første pinsedag', $easter->addDays(49)),
            Holiday::national('Andre pinsedag', $easter->addDays(50)),
        ];
    }
}
