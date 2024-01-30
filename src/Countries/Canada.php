<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Canada extends Country
{
    public function countryCode(): string
    {
        return 'ca';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            [
                'New Year\'s Day' => new CarbonImmutable($year.'-01-01', 'America/Toronto'),
                'Canada Day' => new CarbonImmutable($year.'-07-01', 'America/Toronto'),
                'Civic Holiday' => new CarbonImmutable(
                    'first monday of August '.$year, 'America/Toronto'
                ),
                'Labour Day' => new CarbonImmutable(
                    'first monday of September '.$year, 'America/Toronto'
                ),
                'National Day for Truth and Reconciliation' => new CarbonImmutable(
                    $year.'-09-30',
                    'America/Toronto'
                ),
                'Remembrance Day' => new CarbonImmutable($year.'-11-11', 'America/Toronto'),
                'Christmas Day' => new CarbonImmutable($year.'-12-25', 'America/Toronto'),
                'Boxing Day' => new CarbonImmutable($year.'-12-26', 'America/Toronto'),
            ],
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $goodFriday = $easter->subDays(2);
        $easterMonday = $easter->addDay();

        $victoriaDay = new CarbonImmutable("last monday of May $year", 'America/Toronto');
        if ($victoriaDay->day < 25) {
            $victoriaDay = $victoriaDay->addWeek();
        }

        $thanksgiving = new CarbonImmutable("second monday of October $year", 'America/Toronto');

        return [
            'Victoria Day' => $victoriaDay,
            'Good Friday' => $goodFriday,
            'Easter Monday' => $easterMonday,
            'Thanksgiving' => $thanksgiving,
        ];
    }
}
