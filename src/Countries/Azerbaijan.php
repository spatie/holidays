<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Azerbaijan extends Country
{
    public function countryCode(): string
    {
        return 'az';
    }

    protected function defaultLocale(): string
    {
        return 'az';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Yeni il', "{$year}-01-01"),
            Holiday::national('Beynəlxalq Qadınlar günü', "{$year}-03-08"),
            Holiday::national('Novruz bayramı', "{$year}-03-20"),
            Holiday::national('Faşizm üzərində qələbə günü', "{$year}-05-09"),
            Holiday::national('Müstəqillik Günü', "{$year}-05-28"),
            Holiday::national('Azərbaycan xalqının milli qurtuluş günü', "{$year}-06-15"),
            Holiday::national('Azərbaycan Respublikasının Silahlı Qüvvələri günü', "{$year}-06-26"),
            Holiday::national('Müstəqilliyin bərpası günü', "{$year}-10-18"),
            Holiday::national('Zəfər Günü', "{$year}-11-08"),
            Holiday::national('Azərbaycan Respublikasının Dövlət bayrağı günü', "{$year}-11-09"),
            Holiday::national('Dünya azərbaycanlılarının həmrəyliyi günü', "{$year}-12-31"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
