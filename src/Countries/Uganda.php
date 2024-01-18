<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Uganda extends Country
{
    public function countryCode(): string
    {
        return 'ug';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day'            => '01-01',
            'Liberation Day'             => '01-26',
            'Archbishop Janani Luwum'    => '02-16',
            'International Women\'s Day' => '03-08',
            'Good Friday'                => '03-29',
            'Eid al-Fitr'                => '04-10',
            'Labour Day'                 => '05-01',
            'Martyr\'s Day'              => '06-03',
            'National Heroes Day'        => '06-09',
            'Eid al-Adha'                => '06-17',
            'Independence Day'           => '10-09',
            'Christmas Day'              => '12-25',
            'Boxing Day'                 => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Africa/Nairobi');

        return [
            'Easter Sunday' => $easter,
            'Easter Monday' => $easter->addDays(),
        ];
    }
}
