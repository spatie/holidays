<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Observable;

class Jamaica extends Country
{
    use Observable;

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

    /** @return array<string, string|CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        $holidays = [
            'New Year\'s Day' => '01-01',
            'Labour Day' => '05-23',
            'Emancipation Day' => '08-01',
            'Independence Day' => '08-06',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ];

        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                'Labour Day', 'Boxing Day' => $this->observed($name, $date, $year),
                default => $this->sundayToNextMonday($date, $year),
            };

            if ($observedDay) {
                $holidays[$name.' Observed'] = $observedDay;
            }
        }

        return $holidays;
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Ash Wednesday' => $easter->subDays(46),
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
            'National Heroes Day' => 'third monday of October',
        ];
    }

    protected function observed(string $name, string $date, int $year): ?CarbonInterface
    {
        $holiday = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")->startOfDay();

        if ($name === 'Labour Day' && $holiday->isSaturday()) {
            return $holiday->next('monday');
        }

        if ($name === 'Boxing Day' && $holiday->isMonday()) {
            return $holiday->next('tuesday');
        }

        return null;
    }
}
