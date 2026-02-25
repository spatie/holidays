<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ukraine extends Country
{
    public function countryCode(): string
    {
        return 'ua';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Новий Рік' => CarbonImmutable::createFromDate($year, 1, 1),
            'Міжнародний жіночий день' => CarbonImmutable::createFromDate($year, 3, 8),
            'День праці' => CarbonImmutable::createFromDate($year, 5, 1),
            'День пам\'яті та перемоги над нацизмом у Другій світовій війні 1939 – 1945 років' => CarbonImmutable::createFromDate($year, 5, 8),
            'День Конституції України' => CarbonImmutable::createFromDate($year, 6, 28),
            'День Української Державності' => CarbonImmutable::createFromDate($year, 7, 15),
            'День Незалежності України' => CarbonImmutable::createFromDate($year, 8, 24),
            'День захисників і захисниць України' => CarbonImmutable::createFromDate($year, 10, 1),
            'Різдво Христове' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            'Великодній Понеділок' => $easter->addDay(),
            'Трійця' => $easter->addDays(50),
        ];
    }
}
