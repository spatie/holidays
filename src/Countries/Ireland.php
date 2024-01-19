<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ireland extends Country
{
    public function countryCode(): string
    {
        return 'ie';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Saint Patrick\'s Day' => '03-17',
            'Christmas Day' => '12-25',
            'Saint Stephen\'s Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $mayHoliday = new CarbonImmutable("first monday of May $year", 'Europe/Dublin');
        $juneHoliday = new CarbonImmutable("first monday of June $year", 'Europe/Dublin');
        $augHoliday = new CarbonImmutable("first monday of August $year", 'Europe/Dublin');
        $octHoliday = new CarbonImmutable("last monday of October $year", 'Europe/Dublin');

        $variableHolidays = [
            'Easter Monday' => $easter->addDays(1),
            'May Public Holiday' => $mayHoliday,
            'June Public Holiday' => $juneHoliday,
            'August Public Holiday' => $augHoliday,
            'October Public Holiday' => $octHoliday,
        ];

        // In 2023, Ireland added a new public holiday for St Brigid's day.
        // It is the First Monday in February, or 1 February if the date falls on a Friday
        if ($year >= 2023) {
            $stBrigidsDay = new CarbonImmutable("$year-02-01", 'Europe/Dublin');
            if (! $stBrigidsDay->isFriday()) {
                $stBrigidsDay = new CarbonImmutable("first monday of February $year", 'Europe/Dublin');
            }
            $variableHolidays['St Brigid\'s Day'] = $stBrigidsDay;
        }

        return $variableHolidays;
    }
}
