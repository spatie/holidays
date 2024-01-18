<?php

namespace Spatie\Holidays\States\Austria;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Austria;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\States\State;

class Carinthia extends State
{
    public static function country(): string
    {
        return Austria::class;
    }

    public function stateCode(): string
    {
        return 'k';
    }

    /** @return array<string, string|CarbonImmutable> */
    public function allHolidays(int $year): array
    {
        return [
            'Josef' => '03-19',
            'Tag der Volksabstimmung' => '10-10',
        ];
    }
}
