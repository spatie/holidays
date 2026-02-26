<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Holiday;

class Iceland extends Country
{
    public function countryCode(): string
    {
        return 'is';
    }

    protected function defaultLocale(): string
    {
        return 'is';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->fixedHolidays($year),
            $this->variableHolidays($year),
        );
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(int $year): array
    {
        return [
            Holiday::national('Nýársdagur', "{$year}-01-01"),
            Holiday::national('Verkalýðsdagurinn', "{$year}-05-01"),
            Holiday::national('Þjóðhátíðardagurinn', "{$year}-06-17"),
            Holiday::national('Jóladagur', "{$year}-12-25"),
            Holiday::national('Annar í jólum', "{$year}-12-26"),
        ];
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        // First Day of Summer: Thursday between 19 and 25 April
        $firstDayOfSummer = CarbonImmutable::createFromDate($year, 4, 19)->next(
            CarbonInterface::THURSDAY,
        )->toImmutable();

        if ($firstDayOfSummer->day > 25) {
            $firstDayOfSummer = $firstDayOfSummer->subWeek();
        }

        // Commerce Day: First Monday in August
        $commerceDay = CarbonImmutable::createFromDate($year, 8, 1);
        if ($commerceDay->dayOfWeek !== CarbonInterface::MONDAY) {
            $commerceDay = $commerceDay->next(CarbonInterface::MONDAY)->toImmutable();
        }

        return [
            Holiday::national('Skírdagur', $easter->subDays(3)),
            Holiday::national('Föstudagurinn langi', $easter->subDays(2)),
            Holiday::national('Páskadagur', $easter),
            Holiday::national('Annar í páskum', $easter->addDay()),
            Holiday::national('Sumardagurinn fyrsti', $firstDayOfSummer),
            Holiday::national('Uppstigningardagur', $easter->addDays(39)),
            Holiday::national('Hvítasunnudagur', $easter->addDays(49)),
            Holiday::national('Annar í hvítasunnu', $easter->addDays(50)),
            Holiday::national('Frídagur verslunarmanna', $commerceDay),
        ];
    }
}
