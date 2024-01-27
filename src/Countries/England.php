<?php

namespace Spatie\Holidays\Countries;

class England extends Wales
{
    public function countryCode(): string
    {
        return 'gb-eng';
    }
}
