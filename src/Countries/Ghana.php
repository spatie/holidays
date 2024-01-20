<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ghana extends Country
{

    protected $timezone = 'Africa/Accra';

    public function countryCode(): string
    {
        return 'gh';
    }

    protected function christmasDay(int $year): array
    {
        $christmasDay = new CarbonImmutable($year . "-12-25", $this->timezone);
        $key = 'Christmas Day';

        if ($christmasDay->isSaturday()) {
            $key .= ' (substitute day)';
            $christmasDay = $christmasDay->next('monday');
        }

        if ($christmasDay->isSunday()) {
            $key .= ' (substitute day)';
            $christmasDay = $christmasDay->next('tuesday');
        }

        return [$key => $christmasDay];
    }


    protected function boxingDay(int $year): array
    {
        $christmasDay = new CarbonImmutable($year . "-12-25", $this->timezone);
        $boxingDay = new CarbonImmutable($year . "-12-26", $this->timezone);
        $key = 'Boxing Day';

        if ($christmasDay->isFriday()) {
            $key .= ' (substitute day)';
            $boxingDay = $boxingDay->next('monday');
        }

        if ($christmasDay->isSaturday()) {
            $key .= ' (substitute day)';
            $boxingDay = $boxingDay->next('tuesday');
        }

        return [$key => $boxingDay];
    }

    /**
     * Get holiday
     * 
     * If it falls on a weekend, the new day to be observed is the next monday
     *
     */
    protected function getHoliday(string $nameOfHoliday, int $year, string $monthAndDay): array
    {
        $newYearsDay = new CarbonImmutable($year . "-" . $monthAndDay, $this->timezone);
        $key = $nameOfHoliday;

        if ($newYearsDay->isWeekend()) {
            $key .= ' (substitute day)';
            $newYearsDay = $newYearsDay->next('monday');
        }

        return [$key => $newYearsDay];
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->getHoliday('New Year Day', $year, "01-01"),
            $this->getHoliday('Constitution Day', $year, "01-07"),
            $this->getHoliday('Independence Day', $year, "03-06"),
            $this->getHoliday('May Day', $year, "05-01"),
            $this->getHoliday('Founders Day', $year, "08-04"),
            $this->getHoliday('Kwame Nkrumah Memorial Day', $year, "09-21"),
            $this->christmasDay($year),
            $this->boxingDay($year),
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone($this->timezone);

        $farmersDay = (new CarbonImmutable('first friday of December ' . $year, $this->timezone));

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
