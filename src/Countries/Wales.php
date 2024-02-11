<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Observable;

class Wales extends Country
{
    use Observable;

    public function countryCode(): string
    {
        return 'gb-cym';
    }

    /** @return array<string, string|CarbonInterface> */
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

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easterSunday = $this->easter($year);

        $goodFriday = $easterSunday->subDays(2);
        $easterMonday = $easterSunday->addDay();

        return [
            'Good Friday' => $goodFriday,
            'Easter Monday' => $easterMonday,
            'Spring bank holiday' => 'last monday of may',
            'Summer bank holiday' => 'last monday of august',
        ];
    }

    /** @return array<string, string|CarbonInterface> */
    protected function earlyMayBankHoliday(int $year): array
    {
        if ($year === 2020) {
            return [
                'Early May bank holiday (VE day)' => (new CarbonImmutable('2020-05-08'))->startOfDay(),
            ];
        }

        if ($year === 2023) {
            return [
                'Bank holiday for the coronation of King Charles III' => (new CarbonImmutable('2020-05-08'))->startOfDay(),
            ];
        }

        return ['Early May bank holiday' => 'first monday of may'];
    }

    /** @return array<string, string|CarbonInterface> */
    protected function oneOffHolidays(int $year): array
    {
        return match ($year) {
            2022 => [
                'Platinum Jubilee bank holiday' => (new CarbonImmutable('2022-06-03'))->startOfDay(),
                'Bank Holiday for the State Funeral of Queen Elizabeth II' => (new CarbonImmutable('2022-09-19'))->startOfDay(),
            ],
            default => [],
        };
    }
}
