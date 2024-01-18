<?php

namespace Spatie\Holidays\States\Germany;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\States\State;

class Saxony extends State
{
    public static function country(): string
    {
        return Germany::class;
    }

    public function stateCode(): string
    {
        return 'sn';
    }

    /** @return array<string, string|CarbonImmutable> */
    public function allHolidays(int $year): array
    {
        return [
            'Reformationstag' => '10-31',
            ...$this->variableHolidays($year),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $dayOfRepentanceAndPrayer = CarbonImmutable::parse($year.'-11-23')
            ->setTimezone('Europe/Berlin');
        $daysToSubtract = ($dayOfRepentanceAndPrayer->format('N') + 4) % 7;

        return [
            'Buß- und Bettag' => $dayOfRepentanceAndPrayer->subDays($daysToSubtract),
        ];
    }
}
