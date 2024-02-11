<?php

namespace Spatie\Holidays\Countries;

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
        ], $this->variableHolidays());

        if ($year >= 2021) {
            $holidays['Juneteenth National Independence Day'] = '06-19';
        }

        return $holidays;
    }

    /** @return array<string, string> */
    protected function variableHolidays(): array
    {
        return [
            'Martin Luther King Day' => 'third monday of January',
            'Presidents\' Day' => 'third monday of February',
            'Memorial Day' => 'last monday of May',
            'Labor Day' => 'first monday of September',
            'Columbus Day' => 'second monday of October',
            'Thanksgiving' => 'fourth thursday of November',
        ];
    }
}
