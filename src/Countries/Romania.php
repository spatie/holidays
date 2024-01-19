<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Romania extends Country
{
    public function countryCode(): string
    {
        return 'ro';
    }

    /**
     * {@inheritDoc}
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Anul Nou' => '01-01',
            'A doua zi de Anul Nou' => '01-02',
            'Bobotează' => '01-06',
            'Sfântul Ion' => '01-07',
            'Ziua Unirii Principatelor Române' => '01-24',
            'Ziua Muncii' => '05-01',
            'Ziua Copilului' => '06-01',
            'Adormirea Maicii Domnului' => '08-15',
            'Sfântul Andrei' => '11-30',
            'Ziua Națională' => '12-01',
            'Crăciunul' => '12-25',
            'A doua zi de Crăciun' => '12-26',
        ], $this->variableHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->orthodoxEaster($year);
        $easterMonday = $easter->addDay();
        $goodFriday = $easter->subDays(2);

        $pentecost = $this->orthodoxPentecost($year);
        $pentecostMonday = $pentecost->addDay();

        return [
            'Vinerea Mare' => $goodFriday,
            'Paștele' => $easter,
            'A doua zi de Paște' => $easterMonday,
            'Rusaliile' => $pentecost,
            'A doua zi de Rusalii' => $pentecostMonday,
        ];
    }

    protected function orthodoxEaster(int $year): CarbonImmutable
    {
        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = intval(floor(($d + $e + 114) / 31));
        $day = (($d + $e + 114) % 31) + 1;

        $gregorianEaster = CarbonImmutable::createFromDate($year, $month, $day);

        // Calculate the difference between Julian and Gregorian calendars
        $daysToAdd = (int)($year / 100) - (int)($year / 400) - 2;

        // Orthodox Church uses Julian calendar to calculate Easter
        return $gregorianEaster->addDays($daysToAdd);
    }

    protected function orthodoxPentecost(int $year): CarbonImmutable
    {
        $easter = $this->orthodoxEaster($year);

        return $easter->addDays(49);
    }
}
