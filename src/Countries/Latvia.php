<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

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
            Holiday::national('Jaunais gads', "{$year}-01-01"),
            Holiday::national('Darba svētki', "{$year}-05-01"),
            Holiday::national('Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena', "{$year}-05-04"),
            Holiday::national('Līgo diena', "{$year}-06-23"),
            Holiday::national('Jāņu diena', "{$year}-06-24"),
            Holiday::national('Latvijas Republikas proklamēšanas diena', "{$year}-11-18"),
            Holiday::national('Ziemassvētku vakars', "{$year}-12-24"),
            Holiday::national('Pirmie Ziemassvētki', "{$year}-12-25"),
            Holiday::national('Otrie Ziemassvētki', "{$year}-12-26"),
            Holiday::national('Vecgada vakars', "{$year}-12-31"),
        ],
            $this->variableHolidays($year),
            $this->observedHolidays($year)
        );
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Lielā Piektdiena', $easter->subDays(2)),
            Holiday::national('Pirmās Lieldienas', $easter),
            Holiday::national('Otrās Lieldienas', $easter->addDay()),
        ];
    }

    /** @return array<Holiday> */
    protected function observedHolidays(int $year): array
    {
        $holidays = [
            'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena' => CarbonImmutable::createFromDate($year, 5, 4),
            'Latvijas Republikas proklamēšanas diena' => CarbonImmutable::createFromDate($year, 11, 18),
        ];

        $result = [];
        foreach ($holidays as $name => $date) {
            $observedDay = $this->weekendToNextMonday($date);

            if ($observedDay) {
                if ($name === 'Latvijas Republikas Neatkarības deklarācijas pasludināšanas diena') {
                    $result[] = Holiday::national('Pārceltā 4. maija brīvdiena', $observedDay);
                }

                if ($name === 'Latvijas Republikas proklamēšanas diena') {
                    $result[] = Holiday::national('Pārceltā 18. novembra brīvdiena', $observedDay);
                }
            }
        }

        return $result;
    }
}
