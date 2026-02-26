<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Holiday;

class Scotland extends Wales
{
    #[\Override]
    public function countryCode(): string
    {
        return 'gb-sct';
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
            '2nd January' => CarbonImmutable::createFromDate($year, 1, 2),
            "St Andrew's Day" => CarbonImmutable::createFromDate($year, 11, 30),
            'Christmas Day' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ];

        $result = [];
        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                '2nd January' => $this->secondOfJanuary($year),
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
    #[\Override]
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Spring bank holiday', CarbonImmutable::parse("last monday of may {$year}")),
            Holiday::national('Summer bank holiday', CarbonImmutable::parse("first monday of august {$year}")),
        ];
    }

    protected function secondOfJanuary(int $year): ?CarbonInterface
    {
        $newYearsDay = new CarbonImmutable("{$year}-01-01")->startOfDay();
        $secondOfJanuary = $newYearsDay->addDay();

        return match ($newYearsDay->dayName) {
            'Friday' => $secondOfJanuary->next('monday'),
            'Saturday', 'Sunday' => $secondOfJanuary->next('tuesday'),
            default => null,
        };
    }
}
