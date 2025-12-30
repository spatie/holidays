<?php

namespace Spatie\Holidays\Calendars;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;

trait ChineseCalendar
{
    protected string $chineseCalendarTimezone = 'Asia/Shanghai';

    private ?IntlDateFormatter $formatter = null;

    public function setChineseCalendarTimezone(string $chineseCalendarTimezone): static
    {
        if ($this->chineseCalendarTimezone !== $chineseCalendarTimezone) {
            $this->chineseCalendarTimezone = $chineseCalendarTimezone;
            $this->formatter = null;
        }

        return $this;
    }

    protected function chineseToGregorianDate(string $input, int $year): CarbonImmutable
    {
        return (new CarbonImmutable)
            ->setTimestamp((int) $this->getFormatter()->parse($year.'-'.$input))
            ->setTimezone(new DateTimeZone($this->chineseCalendarTimezone));
    }

    protected function getFormatter(): IntlDateFormatter
    {
        return $this->formatter ??= new IntlDateFormatter(
            'zh-CN@calendar=chinese',
            IntlDateFormatter::SHORT,
            IntlDateFormatter::NONE,
            $this->chineseCalendarTimezone,
            IntlDateFormatter::TRADITIONAL
        );
    }
}
