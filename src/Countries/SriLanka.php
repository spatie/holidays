<?php

namespace Spatie\Holidays\Countries;

use DateTime;
use Solaris\MoonPhase;
use Carbon\CarbonImmutable;

class SriLanka extends Country
{
    public function countryCode(): string
    {
        return 'lk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge
        ([
            'Thai Pongal Day' => '01-15',
            'Independence Day' => '02-04',
            'Deepavali Festival Day' => '11-14',
            'Christmas' => '12-25',
        ], $this->variableHolidays($year));
    }

    /**
     * todo: add more tamil/hindu holidays and muslim/islamic holidays
     * Excluded some of them since they are lunar / different calendar specifications
     *
     * @return array<string, CarbonImmutable>
     */
    function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Asia/Colombo');

        return[
            'Good Friday' => $easter->subDays(2),
            'Easter Sunday' => $easter->addDay(),
        ];
    }

}
