<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class NorthernIreland extends Wales
{
    public function countryCode(): string
    {
        return 'gb-nir';
    }

    /** @return array<string, CarbonImmutable> */
    private function stPatricksDay(int $year): array
    {
        $stPatricksDay = new CarbonImmutable($year.'-03-17', 'Europe/London');
        $key = 'St Patrick\'s Day';

        if ($stPatricksDay->isWeekend()) {
            $key .= ' (substitute day)';
            $stPatricksDay = $stPatricksDay->next('monday');
        }

        return [$key => $stPatricksDay];
    }

    /** @return array<string, CarbonImmutable> */
    private function battleOfTheBoyne(int $year): array
    {
        $battleOfTheBoyne = new CarbonImmutable($year.'-07-12', 'Europe/London');
        $key = 'Battle of the Boyne (Orangemen\'s Day)';

        if ($battleOfTheBoyne->isWeekend()) {
            $key .= ' (substitute day)';
            $battleOfTheBoyne = $battleOfTheBoyne->next('monday');
        }

        return [$key => $battleOfTheBoyne];
    }

    /** @return array<string, CarbonImmutable> */
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
            $this->stPatricksDay($year),
            $this->earlyMayBankHoliday($year),
            $this->battleOfTheBoyne($year),
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
