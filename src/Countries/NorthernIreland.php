<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonInterface;

class NorthernIreland extends Wales
{
    public function countryCode(): string
    {
        return 'gb-nir';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->observedHolidays($year),
            $this->earlyMayBankHoliday($year),
            $this->variableHolidays($year),
            $this->oneOffHolidays($year),
        );
    }

    /** @return array<string, string|CarbonInterface> */
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            'New Year\'s Day' => '01-01',
            'St Patrick\'s Day' => '03-17',
            'Battle of the Boyne (Orangemen\'s Day)' => '07-12',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ];

        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Christmas Day' => $this->observedChristmasDay($year),
                'Boxing Day' => $this->observedBoxingDay($year),
                default => $this->weekendToNextMonday($date, $year),
            };

            if ($observedDay) {
                $holidays[$name.' (substitute day)'] = $observedDay;
                unset($holidays[$name]);
            }
        }

        return $holidays;
    }
}
