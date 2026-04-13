<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class UnitedStates extends Country
{
    public function countryCode(): string
    {
        return 'us';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Independence Day', "{$year}-07-04"),
            Holiday::national('Veterans Day', "{$year}-11-11"),
            Holiday::national('Christmas', "{$year}-12-25"),
        ], $this->variableHolidays($year));

        if ($year >= 2021) {
            $holidays[] = Holiday::national('Juneteenth National Independence Day', "{$year}-06-19");
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [
            Holiday::national('Martin Luther King Day', CarbonImmutable::parse("third monday of January {$year}")),
            Holiday::national("Presidents' Day", CarbonImmutable::parse("third monday of February {$year}")),
            Holiday::national('Memorial Day', CarbonImmutable::parse("last monday of May {$year}")),
            Holiday::national('Labor Day', CarbonImmutable::parse("first monday of September {$year}")),
            Holiday::national('Columbus Day', CarbonImmutable::parse("second monday of October {$year}")),
            Holiday::national('Thanksgiving', CarbonImmutable::parse("fourth thursday of November {$year}")),
        ];
    }
}
