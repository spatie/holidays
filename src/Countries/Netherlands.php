<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

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
            Holiday::national('Nieuwjaarsdag', "{$year}-01-01"),
            Holiday::national('Eerste kerstdag', "{$year}-12-25"),
            Holiday::national('Tweede kerstdag', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $koningsDag = CarbonImmutable::createFromDate($year, 4, 27);

        if ($koningsDag->isSunday()) {
            $koningsDag = $koningsDag->subDay();
        }

        $easter = $this->easter($year);

        $holidays = [
            Holiday::national('Koningsdag', $koningsDag),
            Holiday::national('Eerste paasdag', $easter),
            Holiday::national('Tweede paasdag', $easter->addDay()),
            Holiday::national('Hemelvaartsdag', $easter->addDays(39)),
            Holiday::national('Eerste pinksterdag', $easter->addDays(49)),
            Holiday::national('Tweede pinksterdag', $easter->addDays(50)),
        ];

        if ($year % 5 === 0) {
            $holidays[] = Holiday::national('Bevrijdingsdag', "{$year}-05-05");
        }

        return $holidays;
    }
}
