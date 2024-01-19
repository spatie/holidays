<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Iran extends Country
{
    public function countryCode(): string
    {
        return 'ir';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Islamic Revolution Day' => '02-11',
            'Nourouz' => '03-19',
            'National Oil Industry Day' => '03-20',
            'Nourouz' => '03-21',
            'Nourouz' => '03-22',
            'Nourouz' => '03-23',
            'Islamic Republic Day' => '03-31',
            'Nature Day' => '04-01',
            'Death of Khomeini' => '04-06',
            '15th Khordad March' => '04-07',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Tehran');

        return [
          //add more holidays
        ];
    }
}