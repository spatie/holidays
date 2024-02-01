<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidCountry extends RuntimeException
{
    public static function notFound(string $countryCode): self
    {
        return new self("Country code `{$countryCode}` is not supported.");
    }
}
