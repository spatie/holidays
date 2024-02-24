<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Concerns\IslamicHolidays;
use Spatie\Holidays\Concerns\WeekendHolidays;
use Spatie\Holidays\Contracts\HasTranslations;

class Jordan extends Country implements HasTranslations
{
    use IslamicHolidays, WeekendHolidays, Translatable;
    public function countryCode(): string
    {
        return 'jo';
    }

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Labor' => '05-01',
            'Independence Day' => '05-25',
            'Christmas Day' => '12-25',
        ], $this->variableHolidays($year));
    }

    protected function variableHolidays(int $year): array
    {
        $this->setTheWeekendDays([CarbonInterface::FRIDAY, CarbonInterface::SATURDAY]);
        $weekendHolidays = $this->getWeekendHolidays($year);

        $islamicHolidays = $this->getIslamicHolidays($year);

        return [...$islamicHolidays, ...$weekendHolidays];
    }
}
