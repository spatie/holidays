<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Croatia extends Country
{
    public function countryCode(): string
    {
        return 'hr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nova godina' => CarbonImmutable::createFromDate($year, 1, 1),
            'Bogojavljenje' => CarbonImmutable::createFromDate($year, 1, 6),
            'Praznik rada' => CarbonImmutable::createFromDate($year, 5, 1),
            'Dan državnosti' => CarbonImmutable::createFromDate($year, 5, 30),
            'Dan antifašističke borbe' => CarbonImmutable::createFromDate($year, 6, 22),
            'Dan pobjede i domovinske zahvalnosti i Dan hrvatskih branitelja' => CarbonImmutable::createFromDate($year, 8, 5),
            'Velika Gospa' => CarbonImmutable::createFromDate($year, 8, 15),
            'Svi sveti' => CarbonImmutable::createFromDate($year, 11, 1),
            'Dan sjećanja na žrtve Domovinskog rata i Dan sjećanja na žrtvu Vukovara i Škabrnje' => CarbonImmutable::createFromDate($year, 11, 18),
            'Božić' => CarbonImmutable::createFromDate($year, 12, 25),
            'Sveti Stjepan' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Uskrsni ponedjeljak' => $easter->addDay(),
            'Tijelovo' => $easter->addDays(60),
        ];
    }
}
