<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Croatia extends Country
{
    public function countryCode(): string
    {
        return 'hr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nova godina', "{$year}-01-01"),
            Holiday::national('Bogojavljenje', "{$year}-01-06"),
            Holiday::national('Praznik rada', "{$year}-05-01"),
            Holiday::national('Dan državnosti', "{$year}-05-30"),
            Holiday::national('Dan antifašističke borbe', "{$year}-06-22"),
            Holiday::national('Dan pobjede i domovinske zahvalnosti i Dan hrvatskih branitelja', "{$year}-08-05"),
            Holiday::national('Velika Gospa', "{$year}-08-15"),
            Holiday::national('Svi sveti', "{$year}-11-01"),
            Holiday::national('Dan sjećanja na žrtve Domovinskog rata i Dan sjećanja na žrtvu Vukovara i Škabrnje', "{$year}-11-18"),
            Holiday::national('Božić', "{$year}-12-25"),
            Holiday::national('Sveti Stjepan', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Uskrsni ponedjeljak', $easter->addDay()),
            Holiday::national('Tijelovo', $easter->addDays(60)),
        ];
    }
}
