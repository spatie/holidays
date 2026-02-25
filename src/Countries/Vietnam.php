<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Calendars\ChineseCalendar;

class Vietnam extends Country
{
    use ChineseCalendar;

    public function countryCode(): string
    {
        return 'vn';
    }

    protected function defaultLocale(): string
    {
        return 'vi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            // New Year's Day
            'Tết Dương Lịch' => CarbonImmutable::createFromDate($year, 1, 1),
            // Day of Southern Liberation and National Reunification
            'Ngày Giải Phóng Miền Nam, Thống Nhất Đất Nước' => CarbonImmutable::createFromDate($year, 4, 30),
            // Labour Day
            'Ngày Quốc Tế Lao Động' => CarbonImmutable::createFromDate($year, 5, 1),
            // Independence Day
            'Ngày Quốc Khánh' => CarbonImmutable::createFromDate($year, 9, 2),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone('Asia/Ho_Chi_Minh');

        return array_merge(
            $this->getHungKingsFestival($year),
            $this->getLunarNewYearHoliday($year),
            $this->getTheExtraDayForIndependenceDay($year),
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function getHungKingsFestival(int $year): array
    {
        return [
            // Hung Kings' Festival
            'Ngày Giỗ Tổ Hùng Vương' => $this->chineseToGregorianDate('03-10', $year),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function getLunarNewYearHoliday(int $year): array
    {
        $firstOfJanInChineseCalendar = $this->chineseToGregorianDate('01-01', $year);

        return [
            // 12-29 the previous year (in Chinese Calendar)
            'Ngày Hai Mươi Chín Tết' => $firstOfJanInChineseCalendar->subDays(2),
            // Lunar New Year's Eve (12-30 in Chinese Calendar)
            'Ngày Ba Mươi Tết' => $firstOfJanInChineseCalendar->subDay(),
            // Lunar New Year Day 1
            'Mùng Một Tết Âm Lịch' => $firstOfJanInChineseCalendar,
            // Lunar New Year Day 2
            'Mùng Hai Tết Âm Lịch' => $firstOfJanInChineseCalendar->addDay(),
            // Lunar New Year Day 3
            'Mùng Ba Tết Âm Lịch' => $firstOfJanInChineseCalendar->addDays(2),
            // Lunar New Year Day 4
            'Mùng Bốn Tết Âm Lịch' => $firstOfJanInChineseCalendar->addDays(3),
            // Lunar New Year Day 5
            'Mùng Năm Tết Âm Lịch' => $firstOfJanInChineseCalendar->addDays(4),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function getTheExtraDayForIndependenceDay(int $year): array
    {
        if ($year < 2021) {
            return [];
        }

        $independenceDay = CarbonImmutable::parse("{$year}-09-02")->startOfDay();

        if ($independenceDay->dayOfWeek === CarbonInterface::MONDAY) {
            return ['Ngày Sau Quốc Khánh' => $independenceDay->addDay()];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::TUESDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::WEDNESDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::THURSDAY) {
            return ['Ngày Sau Quốc Khánh' => $independenceDay->addDay()];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::FRIDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::SATURDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::SUNDAY) {
            return ['Ngày Sau Quốc Khánh' => $independenceDay->addDays(2)];
        }

        return [];
    }
}
