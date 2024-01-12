<?php

namespace Spatie\Holidays\Actions;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Data\Holiday;
use Spatie\Holidays\Exceptions\HolidaysException;

class Belgium implements Executable
{
    protected int $year;

    public function execute(int $year): array
    {
        $this->year = $year;

        $this->ensureYearCanBeCalculated();

        $fixedHolidays = $this->fixedHolidays();
        $variableHolidays = $this->variableHolidays();

        return array_merge($fixedHolidays, $variableHolidays);
    }

    protected function ensureYearCanBeCalculated(): void
    {
        if ($this->year < 1970) {
            throw HolidaysException::yearTooLow($this->year);
        }

        if ($this->year > 2037) {
            throw HolidaysException::yearTooHigh($this->year);
        }
    }

    /** @return array<string, string> */
    protected function fixedHolidays(): array
    {
        $dates = [
            'Nieuwjaar' => '01-01',
            'Dag van de Arbeid' => '05-01',
            'Nationale Feestdag' => '07-21',
            'OLV Hemelvaart' => '08-15',
            'Allerheiligen' => '11-01',
            'Wapenstilstand' => '11-11',
            'Kerstmis' => '12-25',
        ];

        foreach ($dates as $name => $date) {
            $dates[$name] = "{$date}-{$this->year}";
        }

        return $dates;
    }

    /** @return array<string, string> */
    protected function variableHolidays(): array
    {
        $easter = CarbonImmutable::createFromTimestampUTC(easter_date($this->year));

        return [
            'Paasmaandag' => $easter->addDay()->format('m-d-Y'),
            'OH Hemelvaart' => $easter->addDays(39)->format('m-d-Y'),
            'Pinkstermaandag' => $easter->addDays(50)->format('m-d-Y'),
        ];
    }
}
