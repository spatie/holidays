<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Latvia extends Country
{
    public function countryCode(): string
    {
        return 'lv';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Jaunais gads' => '01-01',
            'Darba svētki' => '05-01',
            'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena' => '05-04',
            'Līgo diena' => '06-23',
            'Jāņu diena' => '06-24',
            'Latvijas Republikas proklamēšanas diena' => '11-18',
            'Ziemassvētku vakars' => '12-24',
            'Pirmie Ziemassvētki' => '12-25',
            'Otrie Ziemassvētki' => '12-26',
            'Vecgada vakars' => '12-31',
        ], $this->variableHolidays($year), $this->postponedHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Lielā Piektdiena' => $easter->subDays(2),
            'Pirmās Lieldienas' => $easter,
            'Otrās Lieldienas' => $easter->addDay(),
        ];
    }

    /** @return array<string, string> */
    protected function postponedHolidays(int $year): array
    {
        // If the holidays - May 4 and November 18 - fall on a Saturday or Sunday,
        // the next working day is designated as a holiday.
        $holidays = [];

        $date = new CarbonImmutable();

        $date = $date->setDate($year, 5, 4);
        if ($date->isWeekend()) {
            $holidays['Pārceltā 4. maija brīvdiena'] = $date->nextWeekday()->format('m-d');
        }

        $date = $date->setDate($year, 11, 18);
        if ($date->isWeekend()) {
            $holidays['Pārceltā 18. novembra brīvdiena'] = $date->nextWeekday()->format('m-d');
        }

        return $holidays;
    }
}
