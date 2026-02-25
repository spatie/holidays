<?php

namespace Spatie\Holidays\Contracts;

interface HasRegions
{
    /** @return array<string> */
    public static function regions(): array;

    public function region(): ?string;
}
