<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Kosovo extends Country
{
    public function countryCode(): string
    {
        return 'xk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Viti i Ri' => CarbonImmutable::createFromDate($year, 1, 1),
            'Krishtlindjet ortodokse' => CarbonImmutable::createFromDate($year, 1, 7),
            'Dita Ndërkombëtare e Punës' => CarbonImmutable::createFromDate($year, 5, 1),
            'Dita e Evropës' => CarbonImmutable::createFromDate($year, 5, 9),
            'Krishtlindjet Katolike' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $holidays = [];

        $holidays['Pashkët Katolike'] = $this->easter($year);
        $holidays['Pashkët Ortodokse'] = $this->orthodoxEaster($year);

        if ($year >= 2008) {
            $holidays['Dita e Pavarësisë së Republikës së Kosovës'] = CarbonImmutable::createFromDate($year, 2, 17);
            $holidays['Dita e Kushtetutës së Republikës së Kosovës'] = CarbonImmutable::createFromDate($year, 4, 9);
        }

        // TODO: Implement islamic holidays

        return $holidays;
    }
}
