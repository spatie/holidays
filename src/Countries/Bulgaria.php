<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Bulgaria extends Country
{
    public function countryCode(): string
    {
        return 'bg';
    }

    protected function allHolidays(int $year): array
    {
        $fixedHolidays = $this->fixedHolidays($year);

        return array_merge(
            $fixedHolidays,
            $this->substituteHolidays($fixedHolidays),
            $this->variableHolidays($year),
        );
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(int $year): array
    {
        return [
            Holiday::national('Нова година', "{$year}-01-01"),
            Holiday::national('Ден на Освобождението на България от османско иго', "{$year}-03-03"),
            Holiday::national('Ден на труда и на международната работническа солидарност', "{$year}-05-01"),
            Holiday::national('Гергьовден, Ден на храбростта и Българската армия', "{$year}-05-06"),
            Holiday::national('Ден на светите братя Кирил и Методий, на българската азбука, просвета и култура и на славянската книжовност', "{$year}-05-24"),
            Holiday::national('Ден на Съединението', "{$year}-09-06"),
            Holiday::national('Ден на Независимостта на България', "{$year}-09-22"),
            Holiday::national('Бъдни вечер', "{$year}-12-24"),
            Holiday::national('Рождество Христово', "{$year}-12-25"),
            Holiday::national('Вторият ден на Рождество Христово', "{$year}-12-26"),
        ];
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Разпети петък', $easter->subDays(2)),
            Holiday::national('Велика събота', $easter->subDay()),
            Holiday::national('Великден', $easter),
            Holiday::national('Вторият ден на Великден', $easter->addDay()),
        ];
    }

    /**
     * Since 2017 (Labour Code Art. 154(2)), a fixed holiday (Easter excluded) that
     * falls on a Saturday or Sunday gets a substitute working day off. Holidays that
     * fall on the same weekend cascade onto the working days that follow, rather
     * than each independently shifting to "the next Monday".
     *
     * @param  array<Holiday>  $fixedHolidays
     * @return array<Holiday>
     */
    protected function substituteHolidays(array $fixedHolidays): array
    {
        usort($fixedHolidays, static fn (Holiday $a, Holiday $b): int => $a->date->timestamp <=> $b->date->timestamp);

        $holidayDates = array_map(
            static fn (Holiday $holiday): string => $holiday->date->toDateString(),
            $fixedHolidays,
        );

        $usedDates = [];
        $substitutes = [];

        foreach ($fixedHolidays as $holiday) {
            if (! $holiday->date->isWeekend()) {
                continue;
            }

            $substituteDate = $holiday->date->addDay();

            while (
                $substituteDate->isWeekend()
                || in_array($substituteDate->toDateString(), $holidayDates, true)
                || in_array($substituteDate->toDateString(), $usedDates, true)
            ) {
                $substituteDate = $substituteDate->addDay();
            }

            $usedDates[] = $substituteDate->toDateString();

            $substitutes[] = Holiday::national("{$holiday->name} (неприсъствен ден)", $substituteDate);
        }

        return $substitutes;
    }
}
