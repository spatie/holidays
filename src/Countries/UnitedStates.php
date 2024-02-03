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
            'New Year\'s Day' => '01-01',
            'Independence Day' => '07-04',
            'Veterans Day' => '11-11',
            'Christmas' => '12-25',
        ], $this->variableHolidays($year));

        if ($year >= 2021) {
            $holidays['Juneteenth National Independence Day'] = '06-19';
        }

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $martinLutherKingDay = new CarbonImmutable("third monday of January $year", 'America/Los_Angeles');
        $presidentsDay = new CarbonImmutable("third monday of February $year", 'America/Los_Angeles');
        $memorialDay = new CarbonImmutable("last monday of May $year", 'America/Los_Angeles');
        $laborDay = new CarbonImmutable("first monday of September $year", 'America/Los_Angeles');
        $columbusDay = new CarbonImmutable("second monday of October $year", 'America/Los_Angeles');
        $thanksgiving = new CarbonImmutable("fourth thursday of November $year", 'America/Los_Angeles');

        return [
            'Martin Luther King Day' => $martinLutherKingDay,
            'Presidents\' Day' => $presidentsDay,
            'Memorial Day' => $memorialDay,
            'Labor Day' => $laborDay,
            'Columbus Day' => $columbusDay,
            'Thanksgiving' => $thanksgiving,
        ];
    }
}
