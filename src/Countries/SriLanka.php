<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Exceptions\UnsupportedCountry;

class SriLanka extends Country
{
    public function countryCode(): string
    {
        return 'lk';
    }

    protected function allHolidays(int $year): array
    {
        // Sri lanka has a committee that decides the holidays for the year
        // instead of following a full moon calendar.

        throw UnsupportedCountry::make($this->countryCode());
    }
}
