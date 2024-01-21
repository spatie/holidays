<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class India extends Country
{
    public function countryCode(): string
    {
        return 'in';
    }

    protected function allHolidays(int $year): array
    {
        return [
            'Republic Day' => '01-26',
            'Holi' => '03-25',
            'Good Friday' => '03-29',
            'Id-ul-Fitr' => '04-11',
            'Ram Navmi' => '04-17',
            'Mahavir Jayanti' => '04-21',
            'Id-ul-Zuha (Bakrid)' => '06-17',
            'Independence Day / Parsi New Year’s Day / Nauraj' => '08-15',
            'Janamashtami (Vaishnva)' => '08-26',
            'Mahatma Gandhi’s Birthday' => '10-02',
            'Dussehra' => '10-12',
            'Diwali' => '10-31',
            'Christmas' => '12-25',
        ];
    }

    protected function variableHolidays(int $year): array
    {
        // Add any variable holidays based on calculations
        return [];
    }
}
