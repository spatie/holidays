<?php

namespace Spatie\Holidays\Countries;

use DateTime;
use Solaris\MoonPhase;
use Carbon\CarbonImmutable;

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
            'Day prior to Sinhala & Tamil New Year Day' => '04-13',
            'Sinhala & Tamil New Year Day' => '04-14',
            'Milad-Un-Nabi (Holy Prophet\'s Birthday)' => '10-30',
            'Deepavali Festival Day' => '11-14',
            'Christmas' => '12-25',
        ], $this->variableHolidays($year));
    }

    function variableHolidays(int $year): array
    {
        $poyaDays = $this->getPoyaDays($year);

        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Colombo');

        return[
            'Good Friday' => $easter->subDays(2),
            'Easter Sunday' => $easter->addDay(),
        ] + $poyaDays;
    }

    function getPoyaDays(int $year): array
    {
        $start = new DateTime($year . '-01-01');
        $end = new DateTime($year . '-12-31');

        $fullMoons = [];

        for ($date = $start; $date <= $end; $date->modify('+1 day')) {

            $moonPhase = new MoonPhase($date);

            $nextFullMoon = new DateTime('@' . $moonPhase->getPhaseFullMoon());

            if(!in_array($nextFullMoon, $fullMoons)) {

                // if the next full moon is in the next year, stops the loop
                if($nextFullMoon->format('Y') == $year + 1) {
                    break;
                }

                // relates to the moon cycle still in the previous year
                if($nextFullMoon->format('Y') != $year) {
                    continue;
                }

                $fullMoons[] = $nextFullMoon;

                $date->modify('+14 day');
            }
        }

        $fullMoons = array_map(function($fullMoon) {
            return CarbonImmutable::instance($fullMoon)
                ->setTimezone('Asia/Colombo');
        }, $fullMoons);

        $namedMoons = [];

        foreach ($fullMoons as $moon){

            switch($moon->format('M')) {

                case 'Jan':

                    if(!isset($namedMoons['Duruthu Poya Day']) ) {
                        $namedMoons['Duruthu Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Duruthu Poya Day'] = $moon;
                    }
                    break;

                case 'Feb':

                    if(!isset($namedMoons['Navam Poya Day']) ) {
                        $namedMoons['Navam Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Navam Poya Day'] = $moon;
                    }
                    break;

                case 'Mar':
                    if(!isset($namedMoons['Medin Poya Day']) ) {
                        $namedMoons['Medin Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Medin Poya Day'] = $moon;
                    }
                    break;

                case 'Apr':
                    if(!isset($namedMoons['Bak Poya Day']) ) {
                        $namedMoons['Bak Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Bak Poya Day'] = $moon;
                    }
                    break;

                case 'May':
                    if(!isset($namedMoons['Vesak Poya Day']) ) {
                        $namedMoons['Vesak Poya Day'] = $moon;
                        $namedMoons['Day Following Vesak Poya Day'] = $moon->addDay();
                    } else {
                        $namedMoons['Adhi Vesak Poya Day'] = $moon;
                    }
                    break;

                case 'Jun':
                    if(!isset($namedMoons['Poson Poya Day']) ) {
                        $namedMoons['Poson Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Poson Poya Day'] = $moon;
                    }
                    break;

                case 'Jul':
                    if(!isset($namedMoons['Esala Poya Day']) ) {
                        $namedMoons['Esala Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Esala Poya Day'] = $moon;
                    }
                    break;

                case 'Aug':
                    if(!isset($namedMoons['Nikini Poya Day']) ) {
                        $namedMoons['Nikini Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Nikini Poya Day'] = $moon;
                    }
                    break;

                case 'Sep':
                    if(!isset($namedMoons['Binara Poya Day']) ) {
                        $namedMoons['Binara Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Binara Poya Day'] = $moon;
                    }
                    break;

                case 'Oct':
                    if(!isset($namedMoons['Vap Poya Day']) ) {
                        $namedMoons['Vap Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Vap Poya Day'] = $moon;
                    }
                    break;

                case 'Nov':
                    if(!isset($namedMoons['Il Poya Day']) ) {
                        $namedMoons['Il Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Il Poya Day'] = $moon;
                    }
                    break;

                case 'Dec':
                    if(!isset($namedMoons['Unduvap Poya Day']) ) {
                        $namedMoons['Unduvap Poya Day'] = $moon;
                    } else {
                        $namedMoons['Adhi Unduvap Poya Day'] = $moon;
                    }
                    break;
            }

        }

        return $namedMoons;

    }

}
