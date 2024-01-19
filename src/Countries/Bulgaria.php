<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Bulgaria extends Country
{
    public function countryCode(): string
    {
        return 'bg';
    }

    /**
     * @param int $year
     * @return array<string, string>
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Нова година' => '01-01',
            'Ден на Освобождението на България от османско робство' => '03-01',
            'Ден на труда и на международната работническа солидарност' => '05-01',
            'Великден – християнската религия отбелязва Възкресение Христово' => '05-05',
            'Гергьовден, Ден на храбростта и Българската армия' => '05-06',
            'Денят на българската просвета и култура и на славянската писменост' => '05-24',
            'Съединението на България' => '09-06',
            'Ден на независимостта на България' => '09-22',
            'Коледа 24 декември' => '12-24',
            'Коледа 25 декември' => '12-25',
            'Коледа 26 декември' => '12-26',
        ], $this->variableHolidays($year));
    }

    /**
     * @param int $year
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp($this->calculateEasterDate($year))
            ->setTimezone('Europe/Sofia');

        return [
            'Великден – християнската религия отбелязва Възкресение Христово' => $easter->format('m-d'),
        ];
    }
  
    /**
     * Calculate the date of Easter using the Computus algorithm
     * @param int $year
     * @return CarbonImmutable
     */
    protected function calculateEasterDate($year)
    {
        $a = $year % 19;
        $b = floor($year / 100);
        $c = $year % 100;
        $d = floor($b / 4);
        $e = $b % 4;
        $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = floor($c / 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $month = floor(($h + $l - 7 * $m + 114) / 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;
    
        return CarbonImmutable::create($year, $month, $day);
    }
}
