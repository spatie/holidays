<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Belgium extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'be';
    }

    public function defaultLocale(): string
    {
        return 'nl';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nieuwjaar' => CarbonImmutable::createFromDate($year, 1, 1),
            'Dag van de Arbeid' => CarbonImmutable::createFromDate($year, 5, 1),
            'Nationale Feestdag' => CarbonImmutable::createFromDate($year, 7, 21),
            'OLV Hemelvaart' => CarbonImmutable::createFromDate($year, 8, 15),
            'Allerheiligen' => CarbonImmutable::createFromDate($year, 11, 1),
            'Wapenstilstand' => CarbonImmutable::createFromDate($year, 11, 11),
            'Kerstmis' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Paasmaandag' => $easter->addDay(),
            'OLH Hemelvaart' => $easter->addDays(39),
            'Pinkstermaandag' => $easter->addDays(50),
        ];
    }
}
