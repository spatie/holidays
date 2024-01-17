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
            'New Year\'s Day' => '01-01',
            'NRM Liberation Day' => '01-26',
            'Archbishop Janani Luwum Memorial Day' => '02-16',
            'International Women\'s Day' => '03-08',
            'Labor Day' => '05-01',
            'Uganda Martyr\'s Day' => '06-03',
            'National Heroes\' Day' => '06-09',
            'Independence Day of Uganda' => '10-09',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26'
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Africa/Kampala');

        return [
            'Easter Monday' => $easter->addDay(),
            'Good Friday' => $easter->addDays(-2),
        ];
    }
}
