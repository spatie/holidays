<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class UnitedStates extends Country
{
    public function countryCode(): string
    {
        return 'us';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = array_merge([
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Independence Day' => CarbonImmutable::createFromDate($year, 7, 4),
            'Veterans Day' => CarbonImmutable::createFromDate($year, 11, 11),
            'Christmas' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));

        if ($year >= 2021) {
            $holidays['Juneteenth National Independence Day'] = CarbonImmutable::createFromDate($year, 6, 19);
        }

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            'Martin Luther King Day' => CarbonImmutable::parse("third monday of January {$year}"),
            "Presidents' Day" => CarbonImmutable::parse("third monday of February {$year}"),
            'Memorial Day' => CarbonImmutable::parse("last monday of May {$year}"),
            'Labor Day' => CarbonImmutable::parse("first monday of September {$year}"),
            'Columbus Day' => CarbonImmutable::parse("second monday of October {$year}"),
            'Thanksgiving' => CarbonImmutable::parse("fourth thursday of November {$year}"),
        ];
    }
}
