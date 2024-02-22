<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Syria extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'sy';
    }

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year\n's Day" => '01-01',
            "Mother\n's Day" => '03-21',
            "Teacher\n's Day" => '03-21',
            'Western Easter' => '03-31',
            'Eid al-Fitr' => '04-10',
            'Syrian Independence Day' => '04-17',
            'Labor Day' => '05-01',
            'Eastern Easter' => '05-05',
            "Martyr\n's Day" => '05-06',
            'Eid al-Adha' => '06-16',
            'Islamic New Year' => '07-07',
            'The commemoration of the birth of the Prophet Muhammad' => '09-15',
            'The October Liberation War' => '10-06',
            'Christmas' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays all follow the lunar calendar, so their dates are not confirmed.
        return [];
    }
}
