<?php

namespace Spatie\Holidays\Countries;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;

class Benin extends Country
{
    public function countryCode(): string
    {
        return 'bj';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Fete du Nouvel An' => '01-01',
            'Fete annuelle des religions traditionnelles' => '01-10',
            'Fete du travail' => '05-01',
            'Fete de l\'independance' => '08-01',
            'Jour de la Toussaint' => '11-01',
            'Jour de Noël' => '12-25',
            'Jour de l\'assomption' => '08-15',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year)->setTimezone('Africa/Porto-Novo');

        $hijriYear = Hijri::convertToHijri($easter->format('Y-m-d'))->year;

        return [
            'Lundi de Pâques' => $easter->addDays(1),
            'Jour de l’Ascension' => $easter->addDays(40),
            'Lundi de Pentecôte' => $easter->addDays(50),
            /*
             * Islamic holidays are based on the Hijri calendar and vary by a day or so.
             */
            'Jour du Maouloud' => Hijri::convertToGregorian(12, 3, $hijriYear)->toImmutable(),
            'Fete du Ramadan' => Hijri::convertToGregorian(10, 1, $hijriYear)->toImmutable(),
            'Fete de la Tabaski' => Hijri::convertToGregorian(12, 10, $hijriYear)->toImmutable(),
        ];
    }
}
