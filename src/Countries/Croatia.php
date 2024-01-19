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
            'Nova godina' => '01-01',
            'Bogojavljenje' => '01-06',
            'Praznik rada' => '05-01',
            'Dan državnosti' => '05-30',
            'Dan antifašističke borbe' => '06-22',
            'Dan pobjede i domovinske zahvalnosti i Dan hrvatskih branitelja' => '08-05',
            'Velika Gospa' => '08-15',
            'Svi sveti' => '11-01',
            'Dan sjećanja na žrtve Domovinskog rata i Dan sjećanja na žrtvu Vukovara i Škabrnje' => '11-18',
            'Božić' => '12-25',
            'Sveti Stjepan' => '12-26',
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
