<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

class Wales extends Country
{
    use HasObservedHolidays;

    public function countryCode(): string
    {
        return 'gb-cym';
    }

    /** @return array<Holiday> */
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
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
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

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easterSunday = $this->easter($year);

        $goodFriday = $easterSunday->subDays(2);
        $easterMonday = $easterSunday->addDay();

        return [
            Holiday::national('Good Friday', $goodFriday),
            Holiday::national('Easter Monday', $easterMonday),
            Holiday::national('Spring bank holiday', CarbonImmutable::parse("last monday of may {$year}")),
            Holiday::national('Summer bank holiday', CarbonImmutable::parse("last monday of august {$year}")),
        ];
    }

    /** @return array<Holiday> */
    protected function earlyMayBankHoliday(int $year): array
    {
        if ($year === 2020) {
            return [
                Holiday::national('Early May bank holiday (VE day)', new CarbonImmutable('2020-05-08')->startOfDay()),
            ];
        }

        if ($year === 2023) {
            return [
                Holiday::national('Bank holiday for the coronation of King Charles III', new CarbonImmutable('2020-05-08')->startOfDay()),
            ];
        }

        return [Holiday::national('Early May bank holiday', CarbonImmutable::parse("first monday of may {$year}"))];
    }

    /** @return array<Holiday> */
    protected function oneOffHolidays(int $year): array
    {
        return match ($year) {
            2022 => [
                Holiday::national('Platinum Jubilee bank holiday', new CarbonImmutable('2022-06-03')->startOfDay()),
                Holiday::national('Bank Holiday for the State Funeral of Queen Elizabeth II', new CarbonImmutable('2022-09-19')->startOfDay()),
            ],
            default => [],
        };
    }
}
