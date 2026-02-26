<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Kenya extends Country
{
    public function countryCode(): string
    {
        return 'ke';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Labour day', "{$year}-05-01"),
            Holiday::national('Madaraka Day', "{$year}-06-01"),
            Holiday::national($this->getOctober10HolidayName($year), "{$year}-10-10"),
            Holiday::national('Mashujaa Day', "{$year}-10-20"),
            Holiday::national('Jamhuri Day', "{$year}-12-01"),
            Holiday::national('Christmas', "{$year}-12-25"),
            Holiday::national('Boxing Day', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
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
