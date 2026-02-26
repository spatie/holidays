<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Denmark extends Country
{
    public function countryCode(): string
    {
        return 'dk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nytår', "{$year}-01-01"),
            Holiday::national('Juleaften', "{$year}-12-24"),
            Holiday::national('Juledag', "{$year}-12-25"),
            Holiday::national('Anden Juledag', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $holidays = [
            Holiday::national('Skærtorsdag', $easter->subDays(3)),
            Holiday::national('Langfredag', $easter->subDays(2)),
            Holiday::national('Påskedag', $easter),
            Holiday::national('Anden Påskedag', $easter->addDay()),
            Holiday::national('Kristi Himmelfartsdag', $easter->addDays(39)),
            Holiday::national('Pinse', $easter->addDays(49)),
            Holiday::national('Anden Pinsedag', $easter->addDays(50)),
        ];

        if ($year < 2024) {
            $holidays[] = Holiday::national('Store Bededag', $easter->addDays(26));
        }

        return $holidays;
    }
}
