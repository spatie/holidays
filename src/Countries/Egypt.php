<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Egypt extends Country
{
    public function countryCode(): string
    {
        return 'eg';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Coptic Christmas' => '01-07',
            'Revolution Day January 25' => '01-25',
            'March Equinox' => '03-20',
            'Sinai Liberation' => '04-25',
            'Labor' => '05-01',
            'Coptic Good' => '05-03',
            'Coptic Holy' => '05-04',
            'Coptic Easter' => '05-05',
            'Spring Festival' => '05-06',
            'June Solstice' => '06-20',
            'June 30 Revolution' => '06-30',
            'Day off for June 30 Revolution' => '07-04',
            'Revolution Day July 23' => '07-23',
            'Day off for Revolution Day July 23' => '07-25',
            'Flooding of the Nile' => '08-15',
            'Nayrouz' => '09-11',
            'September Equinox' => '09-22',
            'Armed Forces' => '10-06',
            'Day off for Armed Forces' => '10-10',
            'December Solstice' => '12-21',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays all follow the lunar calendar, so their dates are not confirmed.
        return [];
    }
}
