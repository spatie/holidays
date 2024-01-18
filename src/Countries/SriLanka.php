<?php

namespace Spatie\Holidays\Countries;

class SriLanka extends Country
{
    public function countryCode(): string
    {
        return 'lk';
    }

    protected function allHolidays(int $year): array
    {
        // TODO: Implement allHolidays() method.
    }

    protected function variableHolidays(int $year): array
    {

    }

}
