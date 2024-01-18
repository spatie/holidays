<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Wales extends Country
{
    public function countryCode(): string
    {
        return 'cy';
    }

    private function christmasDay(int $year): array
    {
        $christmasDay = new CarbonImmutable($year . "-12-25", 'Europe/London');
        $key = 'Christmas Day';

        if ($christmasDay->isSaturday() || $christmasDay->isSunday()) {
            $key .= ' (substitute day)';
            $christmasDay = $christmasDay->next('monday');
        }

        return [$key => $christmasDay];
    }


    private function boxingDay(int $year): array
    {
        $boxingDay = new CarbonImmutable($year . "-12-26", 'Europe/London');
        $key = 'Boxing Day';

        if ($boxingDay->isSaturday()) {
            $key .= ' (substitute day)';
            $boxingDay = $boxingDay->next('monday');
        } elseif ($boxingDay->isSunday()) {
            $key .= ' (substitute day)';
            $boxingDay = $boxingDay->next('tuesday');
        }

        return [$key => $boxingDay];
    }


    private function newYearsDay(int $year): array
    {
        $newYearsDay = new CarbonImmutable($year . "-01-01", 'Europe/London');
        $key = 'New Year\'s Day';

        if ($newYearsDay->isSaturday() || $newYearsDay->isSunday()) {
            $key .= ' (substitute day)';
            $newYearsDay = $newYearsDay->next('monday');
        }

        return [$key => $newYearsDay];
    }


    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->newYearsDay($year),
            [
                'Early May bank holiday' => new CarbonImmutable("first monday of may {$year}", 'Europe/London'),
                'Spring bank holiday' => new CarbonImmutable("last monday of may {$year}", 'Europe/London'),
                'Summer bank holiday' => new CarbonImmutable("last monday of august {$year}", 'Europe/London'),
            ],
            $this->christmasDay($year),
            $this->boxingDay($year),
            $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easterSunday = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/London');

        $goodFriday = $easterSunday->subDays(2);
        $easterMonday = $easterSunday->addDay();

        return [
            'Good Friday' => $goodFriday,
            'Easter Monday' => $easterMonday,
        ];
    }
}
