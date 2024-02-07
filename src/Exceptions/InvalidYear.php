<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidYear extends RuntimeException
{
    public static function yearTooLow(int $year): self
    {
        return new self("Holidays can only be calculated for years after {$year}.");
    }

    public static function yearTooHigh(int $year): self
    {
        return new self("Holidays can only be calculated for years before {$year}.");
    }

    public static function range(string $country, int $start, int $end): self
    {
        return new self("Only years between {$start} and {$end} are supported for {$country}.");
    }
}
