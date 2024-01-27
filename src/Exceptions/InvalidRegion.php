<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidRegion extends RuntimeException
{
    public static function unsupportedRegion(string $region): self
    {
        return new self("Region '$region' is not supported.");
    }

    public static function unsupportedLocale(string $locale): self
    {
        return new self("Locale '$locale' is not supported.");
    }
}
