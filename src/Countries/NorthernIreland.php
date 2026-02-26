<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class NorthernIreland extends Wales
{
    #[\Override]
    public function countryCode(): string
    {
        return 'gb-nir';
    }

    #[\Override]
    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->observedHolidays($year),
            $this->earlyMayBankHoliday($year),
            $this->variableHolidays($year),
            $this->oneOffHolidays($year),
        );
    }

    /** @return array<Holiday> */
    #[\Override]
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            "St Patrick's Day" => CarbonImmutable::createFromDate($year, 3, 17),
            "Battle of the Boyne (Orangemen's Day)" => CarbonImmutable::createFromDate($year, 7, 12),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ];

        $result = [];
        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Christmas Day' => $this->observedChristmasDay($date),
                'Boxing Day' => $this->observedBoxingDay($date),
                default => $this->weekendToNextMonday($date),
            };

            if ($observedDay) {
                $result[] = Holiday::national("{$name} (substitute day)", $observedDay);
            } else {
                $result[] = Holiday::national($name, $date);
            }
        }

        return $result;
    }
}
