<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Georgia extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'ge';
    }

    public function defaultLocale(): string
    {
        return 'ge';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'ახალი წელი' => '01-01',
            'ახალი წლის სადღესასწაულო დღე' => '01-02',
            'შობა' => '01-07',
            'ნათლისღება' => '01-19',
            'დედის დღე' => '03-03',
            'ქალთა საერთაშორისო დღე' => '03-08',
            'ერთიანობის დღე' => '04-09',
            'გამარჯვების დღე' => '05-09',
            'წმ. ანდრია პირველწოდებულის ხსენების დღე' => '05-12',
            'ოჯახის სიწმინდის დღე' => '05-17',
            'დამოუკიდებლობის დღე' => '05-26',
            'მარიამობა' => '08-28',
            'სვეტიცხოვლობა' => '10-14',
            'გიორგობა' => '11-23',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);

        return [
            'აღდგომა' => $orthodoxEaster,
            'წითელი პარასკევი' => $orthodoxEaster->subDays(2),
            'დიდი შაბათი' => $orthodoxEaster->subDay(),
            'მიცვალებულთა მოხსენიების დღე' => $orthodoxEaster->addDay(),
        ];
    }
}
