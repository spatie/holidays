<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class HolidaysException extends RuntimeException
{
    public static function unknownCountryCode(string $countryCode): self
    {
        return new self("Country code `{$countryCode}` is not supported");
    }
}
