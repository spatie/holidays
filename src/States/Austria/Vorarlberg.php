<?php

namespace Spatie\Holidays\States\Austria;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Austria;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\States\State;

class Vorarlberg extends State
{
    public static function country(): string
    {
        return Austria::class;
    }

    public function stateCode(): string
    {
        return 'v';
    }

    /** @return array<string, string|CarbonImmutable> */
    public function allHolidays(int $year): array
    {
        return [
            'Josef' => '03-19',
        ];
    }
}
