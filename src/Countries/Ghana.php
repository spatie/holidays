<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ghana extends Country
{
    public function countryCode(): string
    {
        return 'gh';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year Day' => '01-01',
            'Constitution Day' => '01-07',
            'Independence Day' => '03-06',
            'May Day' => '05-01',
            'Founders Day' => '08-04',
            'Kwame Nkrumah Memorial Day' => '09-21',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Africa/Accra');

        $farmersDay = (new CarbonImmutable('first friday of December ' . $year, 'Africa/Accra'));

        return [
            'Farmers Day' => $farmersDay,

            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),

            // NB: *** There are no fixed dates for the Eid-Ul-Fitr and Eid-Ul-Adha because they are movable feasts.
            // The dates for their observation are provided by the Office of the Chief Imam in the course of the year.
            // 'Eid-Ul-Fitr' => "",
            // 'Eid-Ul-Adha' => "",
        ];
    }
}
