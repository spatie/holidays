<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Exceptions\InvalidCountry;

class SriLanka extends Country
{
    public function countryCode(): string
    {
        return 'lk';
    }

    protected function allHolidays(int $year): array
    {
        throw InvalidCountry::notCalculable(
            $this->countryCode(),
            'Sri Lanka uses a government committee to determine holidays each year, so they cannot be computed programmatically.',
        );
    }
}
