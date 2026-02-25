<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\HasObservedHolidays;

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

    /** @return array<string, CarbonImmutable> */
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

        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Labour Day', 'Boxing Day' => $this->observed($name, $date, $year),
                default => $this->sundayToNextMonday($date),
            };

            if ($observedDay) {
                $holidays[$name.' Observed'] = $observedDay;
            }
        }

        return $holidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Ash Wednesday' => $easter->subDays(46),
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
            'National Heroes Day' => CarbonImmutable::parse('third monday of October '.$year),
        ];
    }

    protected function observed(string $name, CarbonImmutable $date, int $year): ?CarbonInterface
    {
        $holiday = $date;

        if ($name === 'Labour Day' && $holiday->isSaturday()) {
            return $holiday->next('monday');
        }

        if ($name === 'Boxing Day' && $holiday->isMonday()) {
            return $holiday->next('tuesday');
        }

        return null;
    }
}
