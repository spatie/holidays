<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\HasObservedHolidays;

class Latvia extends Country
{
    use HasObservedHolidays;

    public function countryCode(): string
    {
        return 'lv';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Jaunais gads' => CarbonImmutable::createFromDate($year, 1, 1),
            'Darba svētki' => CarbonImmutable::createFromDate($year, 5, 1),
            'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena' => CarbonImmutable::createFromDate($year, 5, 4),
            'Līgo diena' => CarbonImmutable::createFromDate($year, 6, 23),
            'Jāņu diena' => CarbonImmutable::createFromDate($year, 6, 24),
            'Latvijas Republikas proklamēšanas diena' => CarbonImmutable::createFromDate($year, 11, 18),
            'Ziemassvētku vakars' => CarbonImmutable::createFromDate($year, 12, 24),
            'Pirmie Ziemassvētki' => CarbonImmutable::createFromDate($year, 12, 25),
            'Otrie Ziemassvētki' => CarbonImmutable::createFromDate($year, 12, 26),
            'Vecgada vakars' => CarbonImmutable::createFromDate($year, 12, 31),
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

    /** @return array<string, CarbonImmutable> */
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena' => CarbonImmutable::createFromDate($year, 5, 4),
            'Latvijas Republikas proklamēšanas diena' => CarbonImmutable::createFromDate($year, 11, 18),
        ];

        foreach ($holidays as $name => $date) {
            $observedDay = $this->weekendToNextMonday($date);

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
