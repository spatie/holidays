<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Kosovo extends Country
{
    public function countryCode(): string
    {
        return 'xk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Viti i Ri', "{$year}-01-01"),
            Holiday::national('Krishtlindjet ortodokse', "{$year}-01-07"),
            Holiday::national('Dita Ndërkombëtare e Punës', "{$year}-05-01"),
            Holiday::national('Dita e Evropës', "{$year}-05-09"),
            Holiday::national('Krishtlindjet Katolike', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::national('Pashkët Katolike', $this->easter($year));
        $holidays[] = Holiday::national('Pashkët Ortodokse', $this->orthodoxEaster($year));

        if ($year >= 2008) {
            $holidays[] = Holiday::national('Dita e Pavarësisë së Republikës së Kosovës', "{$year}-02-17");
            $holidays[] = Holiday::national('Dita e Kushtetutës së Republikës së Kosovës', "{$year}-04-09");
        }

        return $holidays;
    }
}
