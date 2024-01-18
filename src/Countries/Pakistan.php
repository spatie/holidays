<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Pakistan extends Country
{
    /**
     * Country Code
     *
     * @return string
     */
    public function countryCode(): string
    {
        return 'pk';
    }

    /**
     * All Holiday In Country
     *
     * @param integer $year
     * 
     * @return array
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Kashmir Solidarity Day'    => '02-05',
            'Pakistan Resolution Day'   => '03-23',
            'Labour Day'                => '05-01',
            'Independence Day'          => '08-14',
            'Iqbal Day'                 => '11-09',
            'Quaid-e-Azam Day'          => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // As Islamic holidays are lunar based.
        // https://github.com/spatie/holidays/discussions/79

        return [
            //
        ];
    }
}
