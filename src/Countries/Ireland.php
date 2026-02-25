<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ireland extends Country
{
    public function countryCode(): string
    {
        return 'ie';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            "Saint Patrick's Day" => CarbonImmutable::createFromDate($year, 3, 17),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            "Saint Stephen's Day" => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $variableHolidays = [
            'Easter Monday' => $this->easter($year)->addDay(),
            'May Public Holiday' => CarbonImmutable::parse("first monday of May {$year}"),
            'June Public Holiday' => CarbonImmutable::parse("first monday of June {$year}"),
            'August Public Holiday' => CarbonImmutable::parse("first monday of August {$year}"),
            'October Public Holiday' => CarbonImmutable::parse("last monday of October {$year}"),
        ];

        if ($year >= 2023) {
            $stBrigidsDay = new CarbonImmutable("{$year}-02-01")->startOfDay();

            if (! $stBrigidsDay->isFriday()) {
                $stBrigidsDay = CarbonImmutable::parse("first monday of February {$year}");
            }

            $variableHolidays["St Brigid's Day"] = $stBrigidsDay;
        }

        return $variableHolidays;
    }
}
