<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Calendars\ChineseCalendar;

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
            '신정' => '01-01',
            '3ㆍ1절' => '03-01',
            '어린이날' => '05-05',
            '현충일' => '06-06',
            '광복절' => '08-15',
            '개천절' => '10-03',
            '한글날' => '10-09',
            '크리스마스' => '12-15',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone('Asia/Seoul');

        return array_merge(
            $this->getLunarNewYearHoliday($year),
            $this->getLunarBuddhasBirthday($year),
            $this->getLunarChuseok($year),
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function getLunarNewYearHoliday(int $year): array
    {
        $firstOfJanInChineseCalendar = $this->chineseToGregorianDate('01-01', $year);

        return [
            '설날 연휴 1' => $firstOfJanInChineseCalendar->subDay(),
            '설날' => $firstOfJanInChineseCalendar,
            '설날 연휴 2' => $firstOfJanInChineseCalendar->addDay(),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function getLunarBuddhasBirthday(int $year): array
    {
        $BuddhasBirthdayInChineseCalendar = $this->chineseToGregorianDate('04-08', $year);

        return [
            '부처님 오신날' => $BuddhasBirthdayInChineseCalendar,
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function getLunarChuseok(int $year): array
    {
        $chuseokInChineseCalendar = $this->chineseToGregorianDate('08-15', $year);

        return [
            '추석 연휴 1' => $chuseokInChineseCalendar->subDay(),
            '추석' => $chuseokInChineseCalendar,
            '추석 연휴 2' => $chuseokInChineseCalendar->addDay(),
        ];
    }
}
