<?php

declare(strict_types=1);

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Nigeria extends Country
{
    public function countryCode(): string
    {
        return 'ng';
    }

    /**
     * {@inheritDoc}
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year' => '01-01',
            'Workers Day' => '05-01',
            'Democracy Day' => '06-12',
            'Independence Day' => '10-01',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        // Holidays like Eid al-Fitr and Eid al-Adha are based on the Islamic calendar
        // which is determined by the sighting of the moon. This makes it impossible
        // to calculate these holidays in advance.

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
