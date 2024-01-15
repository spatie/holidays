<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Netherlands extends Country
{
    public function countryCode(): string
    {
        return 'nl';
    }

    public function get(int $year): array
    {
        $this->ensureYearCanBeCalculated($year);

        $fixedHolidays = $this->fixedHolidays($year);
        $variableHolidays = $this->variableHolidays($year);

        return array_merge($fixedHolidays, $variableHolidays);
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        $dates = [
            'Nieuwjaar' => '01-01',
            'Bevrijdingsdag' => '01-05',
            'Kerstmis' => '25-12',
            '2de Kerstdag' => '26-12',
            'Oudjaar' => '31-12',
        ];

        foreach ($dates as $name => $date) {
            $dates[$name] = CarbonImmutable::createFromFormat('d-m-Y', "{$date}-{$year}");
        }

        return $dates;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $koningsDag = CarbonImmutable::createFromFormat('d-m-Y', "27-04-{$year}");

        if ($koningsDag->isSunday()) {
            $koningsDag = $koningsDag->subDay();
        }

        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Brussels');

        return [
            'Koningsdag' => $koningsDag,
            'Goede vrijdag' => $easter->subDays(2),
            'Paasmaandag' => $easter->addDay(),
            'OLH Hemelvaart' => $easter->addDays(39),
            'Pinksteren' => $easter->addDays(49),
            'Pinkstermaandag' => $easter->addDays(50),
        ];
    }
}
