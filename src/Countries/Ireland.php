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
            'New Year\'s Day' => '01-01',
            'Saint Patrick\'s Day' => '03-17',
            'May Public Holiday' => 'first monday of May',
            'June Public Holiday' => 'first monday of June',
            'August Public Holiday' => 'first monday of August',
            'October Public Holiday' => 'last monday of October',
            'Christmas Day' => '12-25',
            'Saint Stephen\'s Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $variableHolidays = [
            'Easter Monday' => $this->easter($year)->addDay(),
        ];

        if ($year >= 2023) {
            $stBrigidsDay = (new CarbonImmutable("$year-02-01"))->startOfDay();

            if (! $stBrigidsDay->isFriday()) {
                $stBrigidsDay = 'first monday of February';
            }

            $variableHolidays['St Brigid\'s Day'] = $stBrigidsDay;
        }

        return $variableHolidays;
    }
}
