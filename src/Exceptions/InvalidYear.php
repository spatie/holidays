<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidYear extends RuntimeException
{
    public static function yearTooLow(): self
    {
        return new self('Holidays can only be calculated for years after 1970.');
    }

    public static function yearTooHigh(): self
    {
        return new self('Holidays can only be calculated for years before 2038.');
    }

    public static function range(string $country, int $start, int $end): self
    {
        return new self("Only years between {$start} and {$end} are supported for {$country}.");
    }
}
