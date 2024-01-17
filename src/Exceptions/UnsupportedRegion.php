<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class UnsupportedRegion extends RuntimeException
{
    public static function make(string $country, string $region): self
    {
        return new self("Region `{$region}` in Country {$country} is not supported.");
    }
}
