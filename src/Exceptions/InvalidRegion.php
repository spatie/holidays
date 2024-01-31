<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class InvalidRegion extends RuntimeException
{
    public static function notFound(string $region): self
    {
        return new self("Region '$region' is not supported.");
    }
}
