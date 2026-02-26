<?php

namespace Spatie\Holidays\Countries;

class England extends Wales
{
    #[\Override]
    public function countryCode(): string
    {
        return 'gb-eng';
    }
}
