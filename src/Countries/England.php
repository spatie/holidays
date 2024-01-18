<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class England extends Wales
{
    public function countryCode(): string
    {
        return 'en';
    }
}
