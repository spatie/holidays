<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Belarus extends Country
{
    public function countryCode(): string
    {
        return 'by';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Новы год' => '01-01',
            'Новы год (другі дзень)' => '01-02',
            'Нараджэнне Хрыстова (праваслаўнае Раство)' => '01-07',
            'Дзень жанчын' => '03-08',
            'Свята працы' => '05-01',
            'Дзень Перамогі' => '05-09',
            'Дзень Незалежнасці' => '07-03',
            'Дзень Кастрычніцкай рэвалюцыі' => '11-07',
            'Нараджэнне Хрыстова (каталіцкае Раство)' => '12-25',
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
