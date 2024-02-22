<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Bangladesh extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'bd';
    }

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'International Mother Language Day' => '02-21',
            'Birthday of Sheikh Mujibur Rahman' => '03-17',
            'Independence Day' => '03-26',
            'Bengali New Year' => '04-14',
            'May Day' => '05-01',
            'National Mourning Day' => '08-15',
            'Victory Day' => '12-16',
            'Christmas Day' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // The variable holidays all follow the lunar calendar, so their dates are not confirmed.
        return [];
    }
}
