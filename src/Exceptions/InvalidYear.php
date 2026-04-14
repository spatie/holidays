<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidYear extends RuntimeException
{
    public static function range(string $country, int $start, int $end): self
    {
        return new self("Only years between {$start} and {$end} are supported for {$country}.");
    }

    public static function invalidHijriYear(): self
    {
        return new self('Unable to get the Hijri year.');
    }
}
