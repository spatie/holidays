<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use RuntimeException;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Exceptions\InvalidYear;

/** @mixin Country */
trait IslamicCalendar
{
    public function eidAlFitr(int $year): CarbonPeriod
    {
        try {
            $date = self::eidAlFitr[$year];
        } catch (RuntimeException) {
            throw InvalidYear::range($this->countryCode(), 1970, 2037);
        }

        $start = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
        $end = $start->addDays(3);

        return CarbonPeriod::create($start, '1 day', $end);
    }
}
