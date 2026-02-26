<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

class Jamaica extends Country
{
    use HasObservedHolidays;

    public function countryCode(): string
    {
        return 'jm';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->fixedHolidays($year),
            $this->variableHolidays($year),
        );
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(int $year): array
    {
        $holidays = [
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 23),
            'Emancipation Day' => CarbonImmutable::createFromDate($year, 8, 1),
            'Independence Day' => CarbonImmutable::createFromDate($year, 8, 6),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ];

        $result = [];
        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Labour Day', 'Boxing Day' => $this->observed($name, $date, $year),
                default => $this->sundayToNextMonday($date),
            };

            if ($observedDay) {
                $result[] = Holiday::national("{$name} Observed", $observedDay);
            } else {
                $result[] = Holiday::national($name, $date);
            }
        }

        return $result;
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Ash Wednesday', $easter->subDays(46)),
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
            Holiday::national('National Heroes Day', CarbonImmutable::parse("third monday of October {$year}")),
        ];
    }

    protected function observed(string $name, CarbonImmutable $date, int $year): ?CarbonImmutable
    {
        $holiday = $date;

        if ($name === 'Labour Day' && $holiday->isSaturday()) {
            return $holiday->next('monday')->toImmutable();
        }

        if ($name === 'Boxing Day' && $holiday->isMonday()) {
            return $holiday->next('tuesday')->toImmutable();
        }

        return null;
    }
}
