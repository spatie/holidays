<?php

namespace Spatie\Holidays\Contracts;

use Carbon\CarbonImmutable;

interface Islamic
{
    /** @return array<string, CarbonImmutable> */
    public function islamicHolidays(int $year): array;
}
