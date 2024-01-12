<?php

namespace Spatie\Holidays\Actions;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Data\Holiday;

class Belgium implements Executable
{
    protected int $year;

    public function execute(int $year): array
    {
        $this->year = $year;

        $fixedHolidays = $this->fixedHolidays();
        $variableHolidays = $this->variableHolidays();

        return array_merge($fixedHolidays, $variableHolidays);
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(): array
    {
        $dates = [
            'Nieuwjaar' => '01-01',
            'Feest van de Arbeid' => '05-01',
            'Nationale Feestdag' => '07-21',
            'OLV Hemelvaart' => '08-15',
            'Allerheiligen' => '11-01',
            'Wapenstilstand' => '11-11',
            'Kerstmis' => '12-25',
        ];

        return $this->format($dates);
    }

    /** @return array<Holiday> */
    protected function variableHolidays(): array
    {
        $easter = CarbonImmutable::createFromTimestampUTC(easter_date($this->year));

        $dates = [
            'Paasmaandag' => $easter->addDay()->format('m-d-Y'),
            'OLV Hemelvaart' => $easter->addDays(39)->format('m-d-Y'),
            'Pinksteren' => $easter->addDays(49)->format('m-d-Y'),
            'Pinkstermaandag' => $easter->addDays(50)->format('m-d-Y'),
        ];

        return $this->format($dates);
    }

    /**
     * @param array<string, string> $dates
     * @return array<Holiday>
     */
    protected function format(array $dates): array
    {
        $formatted = [];
        foreach ($dates as $name => $date) {
            $formatted[] = Holiday::new(
                name: $name,
                date: "{$date}-{$this->year}",
            );
            $dates[$name] = "{$date}-{$this->year}";
        }

        return $formatted;
    }
}
