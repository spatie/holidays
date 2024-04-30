<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Azerbaijan extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'az';
    }

    public function defaultLocale(): string
    {
        return 'az';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Yeni il' => '01-01',
            'Beynəlxalq Qadınlar günü' => '03-08',
            'Novruz bayramı' => '03-20',
            'Faşizm üzərində qələbə günü' => '05-09',
            'Müstəqillik Günü' => '05-28',
            'Azərbaycan xalqının milli qurtuluş günü' => '06-15',
            'Azərbaycan Respublikasının Silahlı Qüvvələri günü' => '06-26',
            'Müstəqilliyin bərpası günü' => '10-18',
            'Zəfər Günü' => '11-08',
            'Azərbaycan Respublikasının Dövlət bayrağı günü' => '11-09',
            'Dünya azərbaycanlılarının həmrəyliyi günü' => '12-31',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
