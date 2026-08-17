<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Holiday;

class HongKong extends Country
{
    protected string $timezone = 'Asia/Hong_Kong';

    public function countryCode(): string
    {
        return 'hk';
    }

    protected function allHolidays(int $year): array
    {
        $dates = array_filter([
            '一月一日' => "{$year}-01-01",
            '清明節' => $this->chingMingFestival($year),
            '勞動節' => "{$year}-05-01",
            '香港特別行政區成立紀念日' => "{$year}-07-01",
            '國慶日' => "{$year}-10-01",
            '聖誕節' => "{$year}-12-25",
            '聖誕節後第一個周日' => "{$year}-12-26",
            ...$this->variableHolidays($year),
        ]);

        $holidays = [];
        foreach ($dates as $name => $date) {
            $holidays[] = Holiday::national($name, $date);
        }

        usort($holidays, fn (Holiday $a, Holiday $b): int => $a->date <=> $b->date);

        return $this->shiftSundayHolidays($holidays);
    }

    /**
     * Every Sunday is a general holiday in Hong Kong, so a holiday landing on one
     * is moved rather than doubled up. It takes the next day that isn't a holiday
     * yet, which may be several days later during Lunar New Year or Christmas.
     *
     * @param  array<Holiday>  $holidays
     * @return array<Holiday>
     */
    protected function shiftSundayHolidays(array $holidays): array
    {
        $occupiedDates = array_map(
            fn (Holiday $holiday): string => $holiday->date->toDateString(),
            $holidays,
        );

        $shiftedHolidays = [];

        foreach ($holidays as $holiday) {
            if (! $holiday->date->isSunday()) {
                $shiftedHolidays[] = $holiday;

                continue;
            }

            $shiftedDate = $holiday->date->addDay();
            while (in_array($shiftedDate->toDateString(), $occupiedDates, true)) {
                $shiftedDate = $shiftedDate->addDay();
            }

            $occupiedDates[] = $shiftedDate->toDateString();

            $shiftedHolidays[] = Holiday::observed(
                $this->shiftedHolidayName($holiday->name, $holiday->date, $shiftedDate),
                $shiftedDate,
            );
        }

        return $shiftedHolidays;
    }

    /**
     * Build the name a holiday carries once it has been shifted off a Sunday.
     *
     * Lunar New Year spans several consecutive days, so a shifted holiday is named
     * after the lunar day it actually lands on (e.g. 農曆年初一 shifted past 農曆年初二
     * and 農曆年初三 becomes 農曆年初四). All other holidays get the "翌日" (next day)
     * postfix.
     */
    protected function shiftedHolidayName(string $name, CarbonImmutable $original, CarbonImmutable $shifted): string
    {
        $lunarNewYearDays = [
            '農曆年初一' => 1,
            '農曆年初二' => 2,
            '農曆年初三' => 3,
        ];

        if (isset($lunarNewYearDays[$name])) {
            $chineseNumerals = [1 => '一', 2 => '二', 3 => '三', 4 => '四'];

            $landedDay = $lunarNewYearDays[$name] + (int) $original->diffInDays($shifted);

            return "農曆年初{$chineseNumerals[$landedDay]}";
        }

        // Christmas Day on a Sunday moves past the first weekday after Christmas,
        // which keeps its own name, and so becomes the second weekday after it.
        if ($name === '聖誕節') {
            return '聖誕節後第二個周日';
        }

        // Holidays already named after the day following another holiday, and the
        // first weekday after Christmas, keep their name when they move.
        if ($name === '聖誕節後第一個周日' || str_contains($name, '翌日')) {
            return $name;
        }

        return "{$name}翌日";
    }

    /**
     * Ching Ming falls on the Qingming solar term, which alternates between 4 and
     * 5 April. This is the 壽星公式 approximation of that solar term, which holds
     * for the years 1980 through 2099.
     */
    protected function chingMingFestival(int $year): string
    {
        $yearsSince2000 = $year - 2000;

        $day = (int) floor($yearsSince2000 * 0.2422 + 4.81) - (int) floor($yearsSince2000 / 4);

        return "{$year}-04-{$day}";
    }

    /** Make use of lunarCalendar() in Taiwan.php */
    protected function lunarCalendar(string $input, int $year): ?string
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-TW@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL,
        );

        $timestamp = $formatter->parse("{$year}-{$input}");
        if ($timestamp === false) {
            return null;
        }

        $dateTime = new DateTime()
            ->setTimestamp((int) $timestamp)
            ->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('Y-m-d');
    }

    /**
     * @return array<string, string|null>
     */
    protected function variableHolidays(int $year): array
    {
        return array_merge(
            $this->lunarHolidays($year),
            $this->easterHolidays($year),
        );
    }

    /**
     * @return array<string, string|null>
     */
    protected function lunarHolidays(int $year): array
    {
        $lunarDates = [
            '農曆年初一' => '01-01',
            '農曆年初二' => '01-02',
            '農曆年初三' => '01-03',
            '佛誕' => '04-08',
            '端午節' => '05-05',
            '中秋節翌日' => '08-16',
            '重陽節' => '09-09',
        ];

        return array_map(
            fn (string $date): ?string => $this->lunarCalendar($date, $year),
            $lunarDates,
        );
    }

    /**
     * @return array<string, string>
     */
    protected function easterHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            '耶穌受難節' => $easter->subDays(2)->format('Y-m-d'),
            '耶穌受難節翌日' => $easter->subDay()->format('Y-m-d'),
            '復活節星期一' => $easter->addDay()->format('Y-m-d'),
        ];
    }
}
