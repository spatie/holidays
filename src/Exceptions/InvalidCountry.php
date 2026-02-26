<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidCountry extends RuntimeException
{
    public static function notFound(string $countryCode): self
    {
        return new self("Country code `{$countryCode}` is not supported.");
    }

    public static function notCalculable(string $countryCode, string $reason): self
    {
        return new self("Holidays for `{$countryCode}` cannot be calculated: {$reason}");
    }
}
