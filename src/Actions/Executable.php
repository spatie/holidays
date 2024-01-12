<?php

namespace Spatie\Holidays\Actions;

use Carbon\CarbonImmutable;

interface Executable
{
    /** @return array<string, CarbonImmutable> */
    public function execute(int $year): array;
}
