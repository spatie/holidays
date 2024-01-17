<?php

namespace Spatie\Holidays\Exceptions;

use RuntimeException;

class UnsupportedState extends RuntimeException
{
    public static function make(string $stateCode, string $country): self
    {
        return new self("State code `{$stateCode}` in country `{$country}` is not supported.");
    }
}
