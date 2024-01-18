<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Turkey extends Country
{
    public function countryCode(): string
    {
        return 'tr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Yılbaşı' => '01-01',
            'Ulusal Egemenlik ve Çocuk Bayramı' => '04-23',
            'Emek ve Dayanışma Günü' => '05-01',
            'Atatürk\'ü Anma, Gençlik ve Spor Bayramı' => '05-19',
            'Demokrasi ve Millî Birlik Günü' => '07-15',
            'Zafer Bayramı' => '08-30',
            'Cumhuriyet Bayramı Arifesi' => '10-28',
            'Cumhuriyet Bayramı' => '10-29',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            //It will be implemented after Islamic holidays. Because Islamic holidays are lunar based.
            //https://github.com/spatie/holidays/discussions/79
        ];
    }
}
