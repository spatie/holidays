<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\NepaliCalendar;

class Nepal extends Country
{
    use NepaliCalendar;

    public function countryCode(): string
    {
        return 'np';
    }

    /** @return array<string,string> */
    protected function allHolidays(int $year): array
    {
        return array_merge($this->holidayAccordingToGregorianCalendar(), $this->variableHolidays($year));
    }

    /** @return array<string,string> */
    protected function variableHolidays(int $year): array
    {
        return array_merge($this->holidaysAccordingToBikramSambatCalendar($year), $this->holidaysAccordingToLunarCalendar($year));
    }
}
