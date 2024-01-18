<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class India extends Country
{
    public function countryCode(): string
    {
        return 'in';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Republic Day' => '01-26',
            'Independence Day' => '08-15',
            'Gandhi Jayanti' => '10-02',
            'Christmas Day' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Kolkata');

        return [
            'Good Friday' => $easter->subDays(2)
        ];
    }
}
