<?php

namespace Spatie\Holidays\Actions;

use Carbon\CarbonImmutable;
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

    /** @return array<string, CarbonImmutable> */
    protected function fixedHolidays(): array
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
            $dates[$name] = CarbonImmutable::createFromFormat('d-m-Y', "{$date}-{$this->year}");
        }

        return $dates;
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($this->year))
            ->setTimezone('Europe/Brussels');

        return [
            'Paasmaandag' => $easter->addDay(),
            'OH Hemelvaart' => $easter->addDays(39),
            'Pinkstermaandag' => $easter->addDays(50),
        ];
    }
}
