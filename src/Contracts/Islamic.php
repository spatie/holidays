<?php

namespace Spatie\Holidays\Contracts;

use Carbon\CarbonPeriod;

interface Islamic
{
    /** @return array<CarbonPeriod> */
    public function islamicHolidays(int $year): array;

    /** @return CarbonPeriod|array<CarbonPeriod> */
    public function eidAlFitr(int $year): CarbonPeriod|array;
}
