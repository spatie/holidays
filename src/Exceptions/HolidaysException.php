<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class HolidaysException extends RuntimeException
{
    public static function unknownCountryCode(string $countryCode): self
    {
        return new self("Country code `{$countryCode}` is not supported");
    }

    public static function noCountryCode(): self
    {
        return new self("Please provide a country code.");
    }

    public static function yearTooLow(int $year): self
    {
        return new self("Holidays can only be calculated for years after 1970.");
    }

    public static function yearTooHigh(int $year): self
    {
        return new self("Holidays can only be calculated for years before 2038.");
    }
}
