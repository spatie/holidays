<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;
use Carbon\CarbonInterface;

class UnitedStates extends Country
{
    public function countryCode(): string
    {
        return 'us';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = array_merge(
            $this->fixedHolidays($year),
            $this->variableHolidays($year),
        );

        if ($year >= 2021) {
            $holidays[] = Holiday::national('Juneteenth National Independence Day', $this->observed("{$year}-06-19"));
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(int $year): array
    {
        return [
            Holiday::national("New Year's Day", $this->observed("{$year}-01-01")),
            Holiday::national('Independence Day', $this->observed("{$year}-07-04")),
            Holiday::national('Veterans Day', $this->observed("{$year}-11-11")),
            Holiday::national('Christmas', $this->observed("{$year}-12-25")),
        ];
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

    protected function observed(string $dateString): CarbonImmutable
    {
        $date = CarbonImmutable::createFromFormat('Y-m-d', $dateString)->startOfDay();

        return match ($date->dayOfWeek) {
            CarbonInterface::SATURDAY => $date->subDay(),
            CarbonInterface::SUNDAY => $date->addDay(),
            default => $date,
        };
    }
}
