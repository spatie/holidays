<?php

namespace Spatie\Holidays\Contracts;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;

interface Islamic
{
    /** @return array<string, string|CarbonImmutable|CarbonPeriod> */
    public function islamicHolidays(int $year): array;
}
