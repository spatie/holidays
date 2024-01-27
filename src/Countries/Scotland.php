<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Scotland extends Wales
{
    public function countryCode(): string
    {
        return 'gb-sct';
    }

    /** @return array<string, CarbonImmutable> */
    protected function secondOfJanuary(int $year): array
    {
        $newYearsDay = new CarbonImmutable($year.'-01-01', 'Europe/London');
        $secondOfJanuary = new CarbonImmutable($year.'-01-02', 'Europe/London');
        $key = '2nd January';

        if ($newYearsDay->isFriday()) {
            $key .= ' (substitute day)';
            $secondOfJanuary = $secondOfJanuary->next('monday');
        }

        if ($newYearsDay->isWeekend()) {
            $key .= ' (substitute day)';
            $secondOfJanuary = $secondOfJanuary->next('tuesday');
        }

        return [$key => $secondOfJanuary];
    }

    /** @return array<string, CarbonImmutable> */
    private function stAndrewsDay(int $year): array
    {
        $stAndrewsDay = new CarbonImmutable($year.'-11-30', 'Europe/London');
        $key = 'St Andrew\'s Day';

        if ($stAndrewsDay->isWeekend()) {
            $key .= ' (substitute day)';
            $stAndrewsDay = $stAndrewsDay->next('monday');
        }

        return [$key => $stAndrewsDay];
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
            $this->secondOfJanuary($year),
            $this->earlyMayBankHoliday($year),
            [
                'Spring bank holiday' => new CarbonImmutable("last monday of may {$year}", 'Europe/London'),
                'Summer bank holiday' => new CarbonImmutable("first monday of august {$year}", 'Europe/London'),
            ],
            $this->stAndrewsDay($year),
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

        return [
            'Good Friday' => $goodFriday,
        ];
    }
}
