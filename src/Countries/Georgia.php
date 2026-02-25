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
            'ახალი წელი' => CarbonImmutable::createFromDate($year, 1, 1),
            'ახალი წლის სადღესასწაულო დღე' => CarbonImmutable::createFromDate($year, 1, 2),
            'შობა' => CarbonImmutable::createFromDate($year, 1, 7),
            'ნათლისღება' => CarbonImmutable::createFromDate($year, 1, 19),
            'დედის დღე' => CarbonImmutable::createFromDate($year, 3, 3),
            'ქალთა საერთაშორისო დღე' => CarbonImmutable::createFromDate($year, 3, 8),
            'ერთიანობის დღე' => CarbonImmutable::createFromDate($year, 4, 9),
            'გამარჯვების დღე' => CarbonImmutable::createFromDate($year, 5, 9),
            'წმ. ანდრია პირველწოდებულის ხსენების დღე' => CarbonImmutable::createFromDate($year, 5, 12),
            'ოჯახის სიწმინდის დღე' => CarbonImmutable::createFromDate($year, 5, 17),
            'დამოუკიდებლობის დღე' => CarbonImmutable::createFromDate($year, 5, 26),
            'მარიამობა' => CarbonImmutable::createFromDate($year, 8, 28),
            'სვეტიცხოვლობა' => CarbonImmutable::createFromDate($year, 10, 14),
            'გიორგობა' => CarbonImmutable::createFromDate($year, 11, 23),
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
