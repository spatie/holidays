<?php

namespace Spatie\Holidays\States\Austria;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Countries\Austria;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\States\State;

class LowerAustria extends State
{
    public static function country(): string
    {
        return Austria::class;
    }

    public function stateCode(): string
    {
        return 'n';
    }

    /** @return array<string, string|CarbonImmutable> */
    public function allHolidays(int $year): array
    {
        return [
            'Leopold' => '11-15',
        ];
    }
}
