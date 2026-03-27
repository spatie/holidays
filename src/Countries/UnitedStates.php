<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
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
            $this->variableHolidays(),
        );

        if ($year >= 2021) {
            $holidays['Juneteenth National Independence Day'] = $this->observed("{$year}-06-19");
        }

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        return [
            "New Year's Day" => $this->observed("{$year}-01-01"),
            'Independence Day' => $this->observed("{$year}-07-04"),
            'Veterans Day' => $this->observed("{$year}-11-11"),
            'Christmas' => $this->observed("{$year}-12-25"),
        ];
    }

    /** @return array<string, string> */
    protected function variableHolidays(): array
    {
        return [
            'Martin Luther King Day' => 'third monday of January',
            "Presidents' Day" => 'third monday of February',
            'Memorial Day' => 'last monday of May',
            'Labor Day' => 'first monday of September',
            'Columbus Day' => 'second monday of October',
            'Thanksgiving' => 'fourth thursday of November',
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
