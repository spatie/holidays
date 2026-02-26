<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Georgia extends Country
{
    public function countryCode(): string
    {
        return 'ge';
    }

    protected function defaultLocale(): string
    {
        return 'ge';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('ახალი წელი', "{$year}-01-01"),
            Holiday::national('ახალი წლის სადღესასწაულო დღე', "{$year}-01-02"),
            Holiday::national('შობა', "{$year}-01-07"),
            Holiday::national('ნათლისღება', "{$year}-01-19"),
            Holiday::national('დედის დღე', "{$year}-03-03"),
            Holiday::national('ქალთა საერთაშორისო დღე', "{$year}-03-08"),
            Holiday::national('ერთიანობის დღე', "{$year}-04-09"),
            Holiday::national('გამარჯვების დღე', "{$year}-05-09"),
            Holiday::national('წმ. ანდრია პირველწოდებულის ხსენების დღე', "{$year}-05-12"),
            Holiday::national('ოჯახის სიწმინდის დღე', "{$year}-05-17"),
            Holiday::national('დამოუკიდებლობის დღე', "{$year}-05-26"),
            Holiday::national('მარიამობა', "{$year}-08-28"),
            Holiday::national('სვეტიცხოვლობა', "{$year}-10-14"),
            Holiday::national('გიორგობა', "{$year}-11-23"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);

        return [
            Holiday::national('აღდგომა', $orthodoxEaster),
            Holiday::national('წითელი პარასკევი', $orthodoxEaster->subDays(2)),
            Holiday::national('დიდი შაბათი', $orthodoxEaster->subDay()),
            Holiday::national('მიცვალებულთა მოხსენიების დღე', $orthodoxEaster->addDay()),
        ];
    }
}
