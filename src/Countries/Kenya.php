<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Kenya extends Country
{
    public function countryCode(): string
    {
        return 'ke';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "New Year's Day" => CarbonImmutable::createFromDate($year, 1, 1),
            'Labour day' => CarbonImmutable::createFromDate($year, 5, 1),
            'Madaraka Day' => CarbonImmutable::createFromDate($year, 6, 1),
            $this->getOctober10HolidayName($year) => CarbonImmutable::createFromDate($year, 10, 10),
            'Mashujaa Day' => CarbonImmutable::createFromDate($year, 10, 20),
            'Jamhuri Day' => CarbonImmutable::createFromDate($year, 12, 1),
            'Christmas' => CarbonImmutable::createFromDate($year, 12, 25),
            'Boxing Day' => CarbonImmutable::createFromDate($year, 12, 26),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }

    protected function getOctober10HolidayName(int $year): string
    {
        return match (true) {
            $year >= 2024 => 'Mazingira Day',
            $year >= 2022 => 'Utamaduni Day',
            $year >= 2019 => 'Huduma Day',
            default => 'Moi Day'
        };
    }
}
