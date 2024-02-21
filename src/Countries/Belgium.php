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
            'Nieuwjaar' => '01-01',
            'Dag van de Arbeid' => '05-01',
            'Nationale Feestdag' => '07-21',
            'OLV Hemelvaart' => '08-15',
            'Allerheiligen' => '11-01',
            'Wapenstilstand' => '11-11',
            'Kerstmis' => '12-25',
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
