<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Canada extends Country
{
    public function countryCode(): string
    {
        return 'ca';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        $easterSunday = $this->calculateEasterSunday($year);
        $goodFriday = $easterSunday->subDays(2);

        return array_merge(
            [
                'New Year\'s Day' => new CarbonImmutable("$year-01-01", 'America/Toronto'),
                'Good Friday' => $goodFriday,
                'Victoria Day' => new CarbonImmutable("last monday of May $year", 'America/Toronto'),
                'Canada Day' => new CarbonImmutable("$year-07-01", 'America/Toronto'),
                'Civic Holiday' => new CarbonImmutable(
                    "first monday of August $year", 'America/Toronto'
                ),
                'Labour Day' => new CarbonImmutable(
                    "first monday of September $year", 'America/Toronto'
                ),
                'National Day for Truth and Reconciliation' => new CarbonImmutable(
                    "$year-10-30",
                    'America/Toronto'
                ),
                'Thanksgiving' => new CarbonImmutable(
                    "second monday of October $year", 'America/Toronto'
                ),
                'Remembrance Day' => new CarbonImmutable("$year-11-11", 'America/Toronto'),
                'Christmas Day' => new CarbonImmutable("$year-12-25", 'America/Toronto'),
            ],
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $victoriaDay = new CarbonImmutable("last monday of May $year", 'America/Toronto');
        if ($victoriaDay->day < 25) {
            $victoriaDay = $victoriaDay->addWeek();
        }

        $thanksgiving = new CarbonImmutable("second monday of October $year", 'America/Toronto');
        $boxingDay = new CarbonImmutable($year . '-12-26', 'America/Toronto');

        return [
            'Victoria Day' => $victoriaDay,
            'Thanksgiving' => $thanksgiving,
            'Boxing Day' => $boxingDay,
        ];
    }

    private function calculateEasterSunday(int $year): CarbonImmutable
    {
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return new CarbonImmutable("$year-$month-$day", 'America/Toronto');
    }
}
