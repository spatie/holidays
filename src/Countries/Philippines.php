<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Philippines extends Country
{
    public function countryCode(): string
    {
        return 'ph';
    }

    protected function allHolidays(int $year): array
    {
         return array_merge([
            'New Year\'s Day' => '01-01',
            'Araw ng Kagitingan' => '04-01',
            'Labor Day' => '05-01',
            'Independence Day' => '06-12',
            'National Heroes Day' => '08-26',
            'Bonifacio Day' => '11-30',
            'Christmas Day' => '12-25',
            'Rizal Day' => '12-30',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Manila');

        return [
            'Maundy Thursday' => $easter->subDays(3),
            'Good Friday' => $easter->subDays(2),
        ];
    }
}
