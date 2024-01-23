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
            'Новий Рік' => '01-01',
            'Міжнародний жіночий день' => '03-08',
            'День праці' => '05-01',
            'День пам\'яті та перемоги над нацизмом у Другій світовій війні 1939 – 1945 років' => '05-08',
            'День Конституції України' => '06-28',
            'День Української Державності' => '07-15',
            'День Незалежності України' => '08-24',
            'День захисників і захисниць України' => '10-01',
            'Різдво Христове' => '12-25',
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
