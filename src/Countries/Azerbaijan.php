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
            'Yeni il' => CarbonImmutable::createFromDate($year, 1, 1),
            'Beynəlxalq Qadınlar günü' => CarbonImmutable::createFromDate($year, 3, 8),
            'Novruz bayramı' => CarbonImmutable::createFromDate($year, 3, 20),
            'Faşizm üzərində qələbə günü' => CarbonImmutable::createFromDate($year, 5, 9),
            'Müstəqillik Günü' => CarbonImmutable::createFromDate($year, 5, 28),
            'Azərbaycan xalqının milli qurtuluş günü' => CarbonImmutable::createFromDate($year, 6, 15),
            'Azərbaycan Respublikasının Silahlı Qüvvələri günü' => CarbonImmutable::createFromDate($year, 6, 26),
            'Müstəqilliyin bərpası günü' => CarbonImmutable::createFromDate($year, 10, 18),
            'Zəfər Günü' => CarbonImmutable::createFromDate($year, 11, 8),
            'Azərbaycan Respublikasının Dövlət bayrağı günü' => CarbonImmutable::createFromDate($year, 11, 9),
            'Dünya azərbaycanlılarının həmrəyliyi günü' => CarbonImmutable::createFromDate($year, 12, 31),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [];
    }
}
