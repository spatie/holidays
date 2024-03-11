<?php

namespace Spatie\Holidays\Contracts;

use Carbon\CarbonPeriod;

interface Islamic
{
    public function islamicHolidays(int $year): array;

    public function eidAlFitr(int $year): CarbonPeriod|array;
}
