<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Serbia extends Country
{
    protected function __construct(
        public ?string $region = null
    ) {
    }

    public function countryCode(): string
    {
        return 'sr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nova godina - prvi dan' => '01-01',
            'Nova godina - drugi dan' => '01-02',
            'Dan državnosti - prvi dan' => '02-15',
            'Dan državnosti - drugi dan' => '02-16',
            'Praznik rada - prvi dan' => '05-01',
            'Praznik rada - drugi dan' => '05-02',
            'Dan primirja u Prvom svetskom ratu' => '11-11',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(
            $this->orthodoxEastern($year)
        )->setTimezone('Europe/Belgrade');

        return [
            'Vaskršnji ponedeljak' => $easter->addDay(),
            'Veliki petak' => $easter->subDays(2),
        ];
    }

    protected function orthodoxEastern(int $year): int
    {
        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = intval(floor(($d + $e + 114) / 31));
        $day = (($d + $e + 114) % 31) + 1;
        $calcDay = $day + ((int)($year / 100) - (int)($year / 400) - 2);

        return intval(mktime(0, 0, 0, $month, $calcDay, $year));
    }
}
