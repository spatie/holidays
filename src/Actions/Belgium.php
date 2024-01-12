<?php

namespace Spatie\Holidays\Actions;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\HolidaysException;

class Belgium implements Executable
{
    public function execute(int $year): array
    {
        $this->ensureYearCanBeCalculated($year);

        $fixedHolidays = $this->fixedHolidays($year);
        $variableHolidays = $this->variableHolidays($year);

        return array_merge($fixedHolidays, $variableHolidays);
    }

    protected function ensureYearCanBeCalculated(int $year): void
    {
        if ($year < 1970) {
            throw HolidaysException::yearTooLow();
        }

        if ($year > 2037) {
            throw HolidaysException::yearTooHigh();
        }
    }

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(int $year): array
    {
        $dates = [
            'Nieuwjaar' => '01-01',
            'Dag van de Arbeid' => '01-05',
            'Nationale Feestdag' => '21-07',
            'OLV Hemelvaart' => '15-08',
            'Allerheiligen' => '01-11',
            'Wapenstilstand' => '11-11',
            'Kerstmis' => '25-12',
        ];

        foreach ($dates as $name => $date) {
            $dates[$name] = CarbonImmutable::createFromFormat('d-m-Y', "{$date}-{$year}");
        }

        return $dates;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Brussels');

        return [
            'Paasmaandag' => $easter->addDay(),
            'OH Hemelvaart' => $easter->addDays(39),
            'Pinkstermaandag' => $easter->addDays(50),
        ];
    }
}
