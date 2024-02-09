<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class NorthernIreland extends Wales
{
    public function countryCode(): string
    {
        return 'gb-nir';
    }

    protected function allHolidays(int $year): array
    {
        $regularHolidays = array_merge(
            $this->newYearsDay($year),
            $this->stPatricksDay($year),
            $this->earlyMayBankHoliday($year),
            $this->battleOfTheBoyne($year),
            [
                'Spring bank holiday' => 'last monday of may',
                'Summer bank holiday' => 'last monday of august',
            ],
            $this->christmasDay($year),
            $this->boxingDay($year),
            $this->variableHolidays($year)
        );

        $oneOffHolidays = $this->oneOffHolidays($year);

        return array_merge($regularHolidays, $oneOffHolidays);
    }

    /** @return array<string, CarbonInterface> */
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

    /** @return array<string, CarbonInterface> */
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
}
