<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Belarus extends Country
{
    public function countryCode(): string
    {
        return 'by';
    }

    protected function defaultLocale(): string
    {
        return 'be';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Новы год' => CarbonImmutable::createFromDate($year, 1, 1),
            'Новы год (другі дзень)' => CarbonImmutable::createFromDate($year, 1, 2),
            'Нараджэнне Хрыстова (праваслаўнае Раство)' => CarbonImmutable::createFromDate($year, 1, 7),
            'Дзень жанчын' => CarbonImmutable::createFromDate($year, 3, 8),
            'Свята працы' => CarbonImmutable::createFromDate($year, 5, 1),
            'Дзень Перамогі' => CarbonImmutable::createFromDate($year, 5, 9),
            'Дзень Незалежнасці' => CarbonImmutable::createFromDate($year, 7, 3),
            'Дзень Кастрычніцкай рэвалюцыі' => CarbonImmutable::createFromDate($year, 11, 7),
            'Нараджэнне Хрыстова (каталіцкае Раство)' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            'Радаўніца' => $easter->addDays(9),
        ];
    }
}
