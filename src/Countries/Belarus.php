<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

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
            Holiday::national('Новы год', "{$year}-01-01"),
            Holiday::national('Новы год (другі дзень)', "{$year}-01-02"),
            Holiday::national('Нараджэнне Хрыстова (праваслаўнае Раство)', "{$year}-01-07"),
            Holiday::national('Дзень жанчын', "{$year}-03-08"),
            Holiday::national('Свята працы', "{$year}-05-01"),
            Holiday::national('Дзень Перамогі', "{$year}-05-09"),
            Holiday::national('Дзень Незалежнасці', "{$year}-07-03"),
            Holiday::national('Дзень Кастрычніцкай рэвалюцыі', "{$year}-11-07"),
            Holiday::national('Нараджэнне Хрыстова (каталіцкае Раство)', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);

        return [
            Holiday::national('Радаўніца', $easter->addDays(9)),
        ];
    }
}
