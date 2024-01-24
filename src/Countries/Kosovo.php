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
            'Viti i Ri' => '01-01',
            'Krishtlindjet ortodokse' => '01-07',
            'Dita Ndërkombëtare e Punës' => '05-01',
            'Dita e Evropës' => '05-09',
            'Krishtlindjet Katolike' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable|string> */
    protected function variableHolidays(int $year): array
    {
        $holidays = [];

        $holidays['Pashkët Katolike'] = $this->easter($year);
        $holidays['Pashkët Ortodokse'] = $this->orthodoxEaster($year);

        if ($year >= 2008) {
            $holidays['Dita e Pavarësisë së Republikës së Kosovës'] = '02-17';
            $holidays['Dita e Kushtetutës së Republikës së Kosovës'] = '04-09';
        }

        // TODO: Implement islamic holidays

        return $holidays;
    }
}
