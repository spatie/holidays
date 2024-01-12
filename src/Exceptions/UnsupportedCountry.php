<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class UnsupportedCountry extends RuntimeException
{
    public static function make(string $countryCode): self
    {
        return new self("Country code `{$countryCode}` is not supported.");
    }
}
