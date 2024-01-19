<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Sweden extends Country
{
    public function countryCode(): string
    {
        return 'se';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge($this->fixedHolidays($year), $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        return [
            'Nyårsdagen' => CarbonImmutable::create($year, 1, 1),
            'Trettondedag jul' => CarbonImmutable::create($year, 1, 6),
            'Första maj' => CarbonImmutable::create($year, 5, 1),
            'Nationaldagen' => CarbonImmutable::create($year, 6, 6),
            'Juldagen' => CarbonImmutable::create($year, 12, 25),
            'Annandag jul' => CarbonImmutable::create($year, 12, 26),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Stockholm');

        $midsummerDay = CarbonImmutable::create($year, 6, 20)->next(CarbonImmutable::SATURDAY);

        return [
            'Långfredagen' => $easter->subDays(2),
            'Påskdagen' => $easter,
            'Annandag påsk' => $easter->addDay(),
            'Kristi himmelsfärdsdag' => $easter->addDays(39),
            'Pingstdagen' => $easter->addDays(49),
            'Midsommardagen' => $midsummerDay->day > 26
                ? $midsummerDay->subWeek()
                : $midsummerDay,
            'Alla helgons dag' => CarbonImmutable::create($year, 10, 31)
                ->next(CarbonImmutable::SATURDAY),
        ];
    }
}
