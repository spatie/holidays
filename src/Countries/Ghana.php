<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ghana extends Country
{
    public function countryCode(): string
    {
        return 'gh';
    }

    /**
     * Return carbon date for christmas
     *
     * @return CarbonImmutable
     */
    protected function getChristmasDay(int $year)
    {
        return new CarbonImmutable($year . '-12-25');
    }

    protected function christmasDay(int $year): CarbonImmutable
    {
        $christmasDay = $this->getChristmasDay($year);

        if ($christmasDay->isSaturday()) {

            $christmasDay = $christmasDay->next('monday');
        }

        if ($christmasDay->isSunday()) {
            $christmasDay = $christmasDay->next('tuesday');
        }

        return $christmasDay;
    }

    protected function boxingDay(int $year): CarbonImmutable
    {
        $christmasDay = $this->getChristmasDay($year);
        $boxingDay = new CarbonImmutable($year . '-12-26');

        if ($christmasDay->isFriday()) {
            $boxingDay = $boxingDay->next('monday');
        }
        if ($christmasDay->isSaturday()) {
            $boxingDay = $boxingDay->next('tuesday');
        }

        return $boxingDay;
    }

    /**
     * Get holiday
     *
     * For example: If a holiday falls on a weekend, the new day to be observed is the next monday
     */
    protected function getHoliday(int $year, string $monthAndDay): CarbonImmutable
    {
        $newYearsDay = new CarbonImmutable($year . '-' . $monthAndDay);

        if ($newYearsDay->isWeekend()) {
            $newYearsDay = $newYearsDay->next('monday');
        }

        return $newYearsDay;
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            [
                'New Year\'s Day' => $this->getHoliday($year, '01-01'),
                'Constitution Day' => $this->getHoliday($year, '01-07'),
                'Independence Day' => $this->getHoliday($year, '03-06'),
                'May Day' => $this->getHoliday($year, '05-01'),
                'Founder\'s Day' => $this->getHoliday($year, '08-04'),
                'Kwame Nkrumah Memorial Day' => $this->getHoliday($year, '09-21'),
                'Christmas Day' => $this->christmasDay($year),
                'Boxing Day' => $this->boxingDay($year),
            ],
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $farmersDay = new CarbonImmutable('first friday of December ' . $year);

        return [
            'Farmers Day' => $farmersDay,
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),

            // NB: *** There are no fixed dates for the Eid-Ul-Fitr and Eid-Ul-Adha because they are movable feasts.
            // The dates for their observation are provided by the Office of the Chief Imam in the course of the year.
            // 'Eid-Ul-Fitr' => "",
            // 'Eid-Ul-Adha' => "",
        ];
    }
}
