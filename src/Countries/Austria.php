<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Austria extends Country
{
    public function countryCode(): string
    {
        return 'at';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->regionalHolidays(),
            $this->fixedHolidays(),
            $this->variableHolidays($year),
        );
    }

    /** @return array<string, string> */
    protected function fixedHolidays(): array
    {
        return [
            'Neujahr' => '01-01',
            'Heilige Drei Könige' => '01-06',
            'Staatsfeiertag' => '05-01',
            'Mariä Himmelfahrt' => '08-15',
            'Nationalfeiertag' => '10-26',
            'Allerheiligen' => '11-01',
            'Mariä Empfängnis' => '12-08',
            'Christtag' => '12-25',
            'Stefanitag' => '12-26',
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Vienna');

        return [
            'Ostermontag' => $easter->addDay(),
            'Christi Himmelfahrt' => $easter->addDays(39),
            'Pfingstmontag' => $easter->addDays(50),
            'Fronleichnam' => $easter->addDays(60),
        ];
    }

    /** @return array<string, string> */
    protected function regionalHolidays(): array
    {
        return match ($this->region) {
            'bg' => [
                'Martinitag' => '11-11',
            ],
            'ka' => [
                'Kärntner Landtag' => '10-10',
            ],
            'no' => [
                'Niederösterreichischer Leopolditag' => '11-15',
            ],
            'oo' => [
                'Oberösterreichischer Landesfeiertag' => '11-15',
            ],
            'sb' => [
                'Rupertitag' => '09-24',
            ],
            'st' => [
                'Tag der Steiermark' => '10-26',
            ],
            'ti' => [
                'Tiroler Landesfeiertag' => '04-26',
            ],
            'vo' => [
                'Vorarlberger Landtag' => '11-09',
            ],
            'wi' => [
                'Wiener Landtag' => '01-21',
            ],
            default => [],
        };
    }
}
