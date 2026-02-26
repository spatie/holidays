<?php

namespace Spatie\Holidays\Contracts;

use Spatie\Holidays\Holiday;

interface Islamic
{
    /** @return array<Holiday> */
    public function islamicHolidays(int $year): array;
}
