<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Observable;

class Latvia extends Country
{
    use Observable;

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
        ],
            $this->variableHolidays($year),
            $this->observedHolidays($year)
        );
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
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena' => '05-04',
            'Latvijas Republikas proklamēšanas diena' => '11-18',
        ];

        foreach ($holidays as $name => $date) {
            $observedDay = $this->weekendToNextMonday($date, $year);

            if ($observedDay) {
                if ($name === 'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena') {
                    $holidays['Pārceltā 4. maija brīvdiena'] = $observedDay;
                }

                if ($name === 'Latvijas Republikas proklamēšanas diena') {
                    $holidays['Pārceltā 18. novembra brīvdiena'] = $observedDay;
                }
            }
        }

        return $holidays;
    }
}
