<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidLocale extends RuntimeException
{
    public static function notFound(string $country, string $locale): self
    {
        return new self("Locale `{$locale}` is not supported for country `{$country}`.");
    }
}
