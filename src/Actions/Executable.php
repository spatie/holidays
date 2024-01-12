<?php

namespace Spatie\Holidays\Actions;

use Spatie\Holidays\Data\Holiday;

interface Executable
{
    /** @return array<Holiday> */
    public function execute(int $year): array;
}
