<?php

namespace Spatie\Holidays\Actions;

interface Executable
{
    /** @return array<string, string> */
    public function execute(int $year): array;
}
