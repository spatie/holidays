<?php

namespace Spatie\Holidays\States\Germany;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\States\State;

class BY extends State
{
    public static function country(): string
    {
        return Germany::class;
    }

    public function stateCode(): string
    {
        return 'by';
    }

    /** @return array<string, string|CarbonImmutable> */
    public function allHolidays(int $year): array
    {
        return [
            'Heilige Drei Könige' => '01-06',
            'Allerheiligen' => '11-01',
            ...$this->variableHolidays($year),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Berlin');

        return [
            'Fronleichnam' => $easter->addDays(60),
        ];
    }
}
