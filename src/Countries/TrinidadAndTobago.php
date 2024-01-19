<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class TrinidadAndTobago extends Country
{
    public function countryCode(): string
    {
        return 'tt';
    }

    protected function allHolidays(int $year): array
    {
        //Data source: https://otp.tt/trinidad-and-tobago/national-holidays-and-awards/
        return array_merge([
            'New Year' => '01-01',
            'Shouter Baptist Liberation Day' => '03-30',
            'Arrival Day' => '05-30',
            'Labour Day' => '06-19',
            'Emancipation Day' => '08-01',
            'Independence Day' => '08-31',
            'Republic Day' => '09-24',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('America/Port_of_Spain');

        return [
            'Easter Sunday' => $easter,
            'Easter Monday' => $easter->addDay(), //When a Public Holiday falls on a Sunday, the following Monday is a Public Holiday.
            'Good Friday' => $easter->subDays(2),
        ];
    }
}
