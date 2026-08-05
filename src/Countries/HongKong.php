<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Concerns\HasObservedHolidays;
use Spatie\Holidays\Holiday;

class HongKong extends Country {
    use HasObservedHolidays;

    protected string $timezone = 'Asia/Hong_Kong';

    public function countryCode(): string
    {
        return 'hk';
    }

    protected function allHolidays(int $year): array
    {
        $originalHolidays = array_merge([
            '一月一日' => "{$year}-01-01",
            '清明節' => "{$year}-04-05",
            '勞動節' => "{$year}-05-01",
            '香港特別行政區成立紀念日' => "{$year}-07-01",
            '國慶日' => "{$year}-10-01",
            '聖誕節' => "{$year}-12-25",
            '聖誕節後第一個周日' => "{$year}-12-26",
        ], $this->variableHolidays($year));
        $holidayObjects = [];

        foreach ($originalHolidays as $name => $date) {
            $holidayObjects[] = Holiday::national($name, (string)$date);
        }

        // Keep track of every date already taken by a holiday, so that a shifted
        // holiday is never placed on a day that is already a holiday.
        $occupiedDates = array_map(
            fn (Holiday $holiday): string => $holiday->date->toDateString(),
            $holidayObjects,
        );

        $adjustedHolidays = $holidayObjects;

        foreach ($holidayObjects as $holiday) {
            if ($this->sundayToNextMonday($holiday->date) === null) {
                continue;
            }

            // Shift to the next day. If that day is already a holiday (e.g. the
            // following day of Lunar New Year), keep advancing until a free day
            // is found.
            $shiftedDate = $holiday->date->addDay();
            while (in_array($shiftedDate->toDateString(), $occupiedDates, true)) {
                $shiftedDate = $shiftedDate->addDay();
            }

            $occupiedDates[] = $shiftedDate->toDateString();

            $adjustedHolidays[] = Holiday::observed(
                $this->observedHolidayName($holiday->name, $holiday->date, $shiftedDate),
                $shiftedDate,
            );
        }

        return $adjustedHolidays;
    }

    /**
     * Build the name of an observed (shifted) holiday.
     *
     * Lunar New Year spans several consecutive days, so an observed holiday is
     * named after the lunar day it actually lands on (e.g. 農曆年初一 shifted past
     * 農曆年初二 and 農曆年初三 becomes 農曆年初四). All other holidays simply get the
     * "翌日" (next day) postfix.
     */
    protected function observedHolidayName(string $name, CarbonImmutable $original, CarbonImmutable $shifted): string
    {
        $nextDayPostfix = '翌日';

        $lunarNewYearDays = [
            '農曆年初一' => 1,
            '農曆年初二' => 2,
            '農曆年初三' => 3,
        ];

        if (isset($lunarNewYearDays[$name])) {
            $chineseNumerals = [
                1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五',
                6 => '六', 7 => '七', 8 => '八', 9 => '九', 10 => '十',
            ];

            $landedDay = $lunarNewYearDays[$name] + (int) $original->diffInDays($shifted);

            return "農曆年初{$chineseNumerals[$landedDay]}";
        }

        // Some holidays already carry a descriptive name and shouldn't be
        // postfixed again.
        if ($name === '聖誕節後第一個周日' || mb_stripos($name, $nextDayPostfix) !== false) {
            return $name;
        }

        return "{$name}{$nextDayPostfix}";
    }

    /** Make use of lunarCalendar() in Taiwan.php */
    protected function lunarCalendar(string $input, int $year): ?string {
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

        $dateTime = new Datetime()
            ->setTimestamp((int)$timestamp)
            ->setTimezone(new DateTimeZone($this->timezone));

        return $dateTime->format('Y-m-d');
    }

    /**
     * @return array<string, string|null>
     */
    protected function variableHolidays(int $year): array {
        return array_merge(
            $this->lunarHolidays($year),
            $this->easterHolidays($year),
        );
    }

    /**
     * @return array<string, string|null>
     */
    protected function lunarHolidays(int $year): array {
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
    protected function easterHolidays(int $year): array {
        $easter = $this->easter($year);

        return [
            '耶穌受難節' => $easter->subDays(2)->format('Y-m-d'),
            '耶穌受難節翌日' => $easter->subDay()->format('Y-m-d'),
            '復活節星期一' => $easter->addDay()->format('Y-m-d'),
        ];
    }
}
