<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Ukraine extends Country
{
    public function countryCode(): string
    {
        return 'ua';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Новий Рік', "{$year}-01-01"),
            Holiday::national('Міжнародний жіночий день', "{$year}-03-08"),
            Holiday::national('День праці', "{$year}-05-01"),
            Holiday::national('День пам\'яті та перемоги над нацизмом у Другій світовій війні 1939 – 1945 років', "{$year}-05-08"),
            Holiday::national('День Конституції України', "{$year}-06-28"),
            Holiday::national('День Української Державності', "{$year}-07-15"),
            Holiday::national('День Незалежності України', "{$year}-08-24"),
            Holiday::national('День захисників і захисниць України', "{$year}-10-01"),
            Holiday::national('Різдво Христове', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Великодній Понеділок', $easter->addDay()),
            Holiday::national('Трійця', $easter->addDays(50)),
        ];
    }
}
