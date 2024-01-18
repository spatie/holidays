<?php

namespace Spatie\Holidays\Countries;

use DateTime;
use Solaris\MoonPhase;

class SriLanka extends Country
{
    public function countryCode(): string
    {
        return 'lk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge
        ([
            'Thai Pongal Day' => '01-15',
            'Independence Day' => '02-04',
            'Mahasivarathri Day' => '03-04',
            'Good Friday' => '04-10',
            'Day prior to Sinhala & Tamil New Year Day' => '04-13',
            'Sinhala & Tamil New Year Day' => '04-14',
            'May Day' => '05-01',
            'Id-Ul-Fitr' => '05-24',
            'Id-Ul-Alha' => '07-31',
            'Milad-Un-Nabi' => '10-30',
            'Deepavali Festival Day' => '11-14',
            'Christmas' => '12-25',
        ], $this->variableHolidays($year));
    }

    function variableHolidays(int $year): array
    {
        $this->getFullMoons($year);


    }


    function getFullMoons(int $year) : array
    {
        // $moonPhase = (new MoonPhase());

        // gets the UNIX timestamp of the full moons
        //$moon = $moonPhase->getPhaseNextFullMoon();

        // $date = new DateTime('@' . $moon);

        $start = new DateTime($year . '-01-01');
        $end = new DateTime($year . '-12-31');

        $fullMoons = [];

        for ($date = $start; $date <= $end; $date->modify('+1 day')) {

            $moonPhase = new MoonPhase($date);

            $nextFullMoon = new DateTime('@' . $moonPhase->getPhaseNextFullMoon());

            if(!in_array($nextFullMoon, $fullMoons)) {
                $fullMoons[] = $nextFullMoon;
            }
        }

        dd($fullMoons);
    }

}
