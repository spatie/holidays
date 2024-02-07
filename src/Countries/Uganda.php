<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Uganda extends Country
{
    public function countryCode(): string
    {
        return 'ug';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        $holidays_by_official_start_date = array();

        // Independence day celebrations started in 1962
        if ($year >= 1962) {
            $holidays_by_official_start_date['Independence Day of Uganda'] = '10-09';
        }

        // Martyr's day celebrations started in 1964
        if ($year >= 1964) {
            $holidays_by_official_start_date['Uganda Martyr\'s Day'] = '06-03';
        }

        //  'NRM Liberation Day celebrations started in 1987
        if ($year >= 1987) {
            $holidays_by_official_start_date['NRM Liberation Day'] = '01-26';
        }

        // National Heroes day celebration started in 2001
        if ($year >= 2001) {
            $holidays_by_official_start_date['National Heroes\' Day'] = '06-09';
        }

        // Archbishop Janani Luwum Memorial Day celebrations started in 2015
        if ($year >= 2015) {
            $holidays_by_official_start_date['Archbishop Janani Luwum Memorial Day'] = '02-16';
        }
        return array_merge([
            'New Year\'s Day' => '01-01',
            'International Women\'s Day' => '03-08',
            'Labor Day' => '05-01',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26'
        ], $holidays_by_official_start_date,
            $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return array(
            'Easter Monday' => $easter->addDay(),
            'Good Friday' => $easter->addDays(-2),
            'Eid al-Fitr' => $this->eidAlFitr($year),
            'Eid al-Adha' => $this->eidAlAdha($year)
        );
    }
}
