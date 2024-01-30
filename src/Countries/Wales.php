<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Wales extends Country
{
    public function countryCode(): string
    {
        return 'gb-cym';
    }

    /** @return array<string, CarbonImmutable> */
    protected function christmasDay(int $year): array
    {
        $christmasDay = new CarbonImmutable($year.'-12-25', 'Europe/London');
        $key = 'Christmas Day';

        if ($christmasDay->isSaturday()) {
            $key .= ' (substitute day)';
            $christmasDay = $christmasDay->next('monday');
        }

        if ($christmasDay->isSunday()) {
            $key .= ' (substitute day)';
            $christmasDay = $christmasDay->next('tuesday');
        }

        return [$key => $christmasDay];
    }

    /** @return array<string, CarbonImmutable> */
    protected function boxingDay(int $year): array
    {
        $christmasDay = new CarbonImmutable($year.'-12-25', 'Europe/London');
        $boxingDay = new CarbonImmutable($year.'-12-26', 'Europe/London');
        $key = 'Boxing Day';

        if ($christmasDay->isFriday()) {
            $key .= ' (substitute day)';
            $boxingDay = $boxingDay->next('monday');
        }

        if ($christmasDay->isSaturday()) {
            $key .= ' (substitute day)';
            $boxingDay = $boxingDay->next('tuesday');
        }

        return [$key => $boxingDay];
    }

    /** @return array<string, CarbonImmutable> */
    protected function newYearsDay(int $year): array
    {
        $newYearsDay = new CarbonImmutable($year.'-01-01', 'Europe/London');
        $key = 'New Year\'s Day';

        if ($newYearsDay->isWeekend()) {
            $key .= ' (substitute day)';
            $newYearsDay = $newYearsDay->next('monday');
        }

        return [$key => $newYearsDay];
    }

    /** @return array<string, CarbonImmutable> */
    protected function earlyMayBankHoliday(int $year): array
    {
        if ($year === 2020) {
            return [
                'Early May bank holiday (VE day)' => new CarbonImmutable('2020-05-08', 'Europe/London'),
            ];
        }

        if ($year === 2023) {
            return [
                'Bank holiday for the coronation of King Charles III' => new CarbonImmutable('2020-05-08', 'Europe/London'),
            ];
        }

        return ['Early May bank holiday' => new CarbonImmutable("first monday of may {$year}", 'Europe/London')];
    }

    /**
     * @return array|CarbonImmutable[]
     */
    protected function oneOffHolidays(int $year): array
    {
        return match ($year) {
            2022 => [
                'Platinum Jubilee bank holiday' => new CarbonImmutable('2022-06-03', 'Europe/London'),
                'Bank Holiday for the State Funeral of Queen Elizabeth II' => new CarbonImmutable('2022-09-19', 'Europe/London'),
            ],
            default => [],
        };
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        $regularHolidays = array_merge(
            $this->newYearsDay($year),
            $this->earlyMayBankHoliday($year),
            [
                'Spring bank holiday' => new CarbonImmutable("last monday of may {$year}", 'Europe/London'),
                'Summer bank holiday' => new CarbonImmutable("last monday of august {$year}", 'Europe/London'),
            ],
            $this->christmasDay($year),
            $this->boxingDay($year),
            $this->variableHolidays($year)
        );

        $oneOffHolidays = $this->oneOffHolidays($year);

        return array_merge($regularHolidays, $oneOffHolidays);
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easterSunday = $this->easter($year);

        $goodFriday = $easterSunday->subDays(2);
        $easterMonday = $easterSunday->addDay();

        return [
            'Good Friday' => $goodFriday,
            'Easter Monday' => $easterMonday,
        ];
    }
}
