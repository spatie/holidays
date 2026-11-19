<?php

namespace Spatie\Holidays\Countries;

use IntlDateFormatter;
use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Holiday;

class Korea extends Country
{
    use ChineseCalendar;

    public function countryCode(): string
    {
        return 'kr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('신정', "{$year}-01-01"),
            Holiday::national('3ㆍ1절', "{$year}-03-01"),
            Holiday::national('어린이날', "{$year}-05-05"),
            Holiday::national('현충일', "{$year}-06-06"),
            Holiday::national('광복절', "{$year}-08-15"),
            Holiday::national('개천절', "{$year}-10-03"),
            Holiday::national('한글날', "{$year}-10-09"),
            Holiday::national('크리스마스', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /**
     * Lunar dates come from ICU's Korean calendar (dangi), which is reckoned at Seoul's meridian
     * and sometimes puts a new moon a day after the Chinese calendar does (Buddha's Birthday 2023,
     * the Lunar New Year 2028).
     */
    protected function getFormatter(): IntlDateFormatter
    {
        return $this->formatter ??= new IntlDateFormatter(
            'ko-KR@calendar=dangi',
            IntlDateFormatter::SHORT,
            IntlDateFormatter::NONE,
            $this->chineseCalendarTimezone,
            IntlDateFormatter::TRADITIONAL,
            'r-M-d',
        );
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone('Asia/Seoul');

        return array_merge(
            $this->getLunarNewYearHoliday($year),
            $this->getLunarBuddhasBirthday($year),
            $this->getLunarChuseok($year),
        );
    }

    /** @return array<Holiday> */
    protected function getLunarNewYearHoliday(int $year): array
    {
        $firstOfJanInChineseCalendar = $this->chineseToGregorianDate('01-01', $year);

        return [
            Holiday::national('설날 연휴 1', $firstOfJanInChineseCalendar->subDay()),
            Holiday::national('설날', $firstOfJanInChineseCalendar),
            Holiday::national('설날 연휴 2', $firstOfJanInChineseCalendar->addDay()),
        ];
    }

    /** @return array<Holiday> */
    protected function getLunarBuddhasBirthday(int $year): array
    {
        $BuddhasBirthdayInChineseCalendar = $this->chineseToGregorianDate('04-08', $year);

        return [
            Holiday::national('부처님 오신날', $BuddhasBirthdayInChineseCalendar),
        ];
    }

    /** @return array<Holiday> */
    protected function getLunarChuseok(int $year): array
    {
        $chuseokInChineseCalendar = $this->chineseToGregorianDate('08-15', $year);

        return [
            Holiday::national('추석 연휴 1', $chuseokInChineseCalendar->subDay()),
            Holiday::national('추석', $chuseokInChineseCalendar),
            Holiday::national('추석 연휴 2', $chuseokInChineseCalendar->addDay()),
        ];
    }
}
