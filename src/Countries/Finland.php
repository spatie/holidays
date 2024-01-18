<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Finland extends Country
{
    public function countryCode(): string
    {
        return 'fi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge($this->fixedHolidays($year), $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        return [
            'Uudenvuodenpäivä' => CarbonImmutable::create($year, 1, 1),
            'Loppiainen' => CarbonImmutable::create($year, 1, 6),
            'Vappu' => CarbonImmutable::create($year, 5, 1),
            'Itsenäisyyspäivä' => CarbonImmutable::create($year, 12, 6),
            'Joulupäivä' => CarbonImmutable::create($year, 12, 25),
            'Tapaninpäivä' => CarbonImmutable::create($year, 12, 26),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Helsinki');

        $midsummerDay = CarbonImmutable::create($year, 6, 20)->next(CarbonImmutable::SATURDAY);

        return [
            'Pitkäperjantai' => $easter->subDays(2),
            'Pääsiäispäivä' => $easter,
            'Toinen pääsiäispäivä' => $easter->addDay(),
            'Helatorstai' => $easter->addDays(39),
            'Helluntaipäivä' => $easter->addDays(49),
            'Juhannuspäivä' => $midsummerDay->day > 26
                ? $midsummerDay->subWeek()
                : $midsummerDay,
            'Pyhäinpäivä' => CarbonImmutable::create($year, 10, 31)
                ->next(CarbonImmutable::SATURDAY),
        ];
    }
}
