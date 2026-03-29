<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Ireland extends Country
{
    public function countryCode(): string
    {
        return 'ie';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national("Saint Patrick's Day", "{$year}-03-17"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national("Saint Stephen's Day", "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $variableHolidays = [
            Holiday::national('Easter Monday', $this->easter($year)->addDay()),
            Holiday::national('May Public Holiday', CarbonImmutable::parse("first monday of May {$year}")),
            Holiday::national('June Public Holiday', CarbonImmutable::parse("first monday of June {$year}")),
            Holiday::national('August Public Holiday', CarbonImmutable::parse("first monday of August {$year}")),
            Holiday::national('October Public Holiday', CarbonImmutable::parse("last monday of October {$year}")),
        ];

        if ($year >= 2023) {
            $stBrigidsDay = new CarbonImmutable("{$year}-02-01")->startOfDay();

            if (! $stBrigidsDay->isFriday()) {
                $stBrigidsDay = CarbonImmutable::parse("first monday of February {$year}");
            }

            $variableHolidays[] = Holiday::national("St Brigid's Day", $stBrigidsDay);
        }

        return $variableHolidays;
    }
}
