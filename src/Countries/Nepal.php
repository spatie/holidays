<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Nepal extends Country
{
    protected function __construct(
        public ?string $region = null
    ) {
    }

    public function countryCode(): string
    {
        return 'np';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year' => '01-01',
            'International Labour Day' => '05-01',
            'Christmas Day' => '12-25',
        ], []);
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            // Return specific holidays for this year
        ];
    }
}
