<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Calendars\ChineseCalendar;

class Vietnam extends Country
{
    use ChineseCalendar;

    public function countryCode(): string
    {
        return 'vn';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            // New Year's Day
            'Tết Dương Lịch' => '01-01',
            // Reunification Day
            'Ngày Giải Phóng Miền Nam, Thống Nhất Đất Nước' => '04-30',
            // Labour Day
            'Ngày Quốc Tế Lao Động' => '05-01',
            // Independence Day
            'Ngày Quốc Khánh' => '09-02',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $this->setTimezoneForChineseCalendar('Asia/Ho_Chi_Minh');

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
            'Ngày Giỗ Tổ Hùng Vương' => $this->chineseToGregorianDate('03/10', $year),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function getLunarNewYearHoliday(int $year): array
    {
        return [
            // 12-29 the previous year
            'Ngày Hai Mươi Chín Tết' => $this->chineseToGregorianDate('12/29', $year - 1),
            // Lunar New Year's Eve
            'Ngày Ba Mươi Tết' => $this->chineseToGregorianDate('12/30', $year - 1),
            // Lunar New Year Day 1
            'Mùng Một Tết Âm Lịch' => $this->chineseToGregorianDate('01/01', $year),
            // Lunar New Year Day 2
            'Mùng Hai Tết Âm Lịch' => $this->chineseToGregorianDate('01/02', $year),
            // Lunar New Year Day 3
            'Mùng Ba Tết Âm Lịch' => $this->chineseToGregorianDate('01/03', $year),
            // Lunar New Year Day 4
            'Mùng Bốn Tết Âm Lịch' => $this->chineseToGregorianDate('01/04', $year),
            // Lunar New Year Day 5
            'Mùng Năm Tết Âm Lịch' => $this->chineseToGregorianDate('01/05', $year),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function getTheExtraDayForIndependenceDay(int $year): array
    {
        if ($year < 2021) {
            return [];
        }

        $independenceDay = CarbonImmutable::parse("$year-09-02")
            ->setTimeZone("Asia/Ho_Chi_Minh");

        if ($independenceDay->dayOfWeek == CarbonImmutable::MONDAY) {
            return ['Ngày Sau Quốc Khánh' => $independenceDay->addDay()];
        }

        if ($independenceDay->dayOfWeek == CarbonImmutable::TUESDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek == CarbonImmutable::WEDNESDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek == CarbonImmutable::THURSDAY) {
            return ['Ngày Sau Quốc Khánh' => $independenceDay->addDay()];
        }

        if ($independenceDay->dayOfWeek == CarbonImmutable::FRIDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek == CarbonImmutable::SATURDAY) {
            return ['Ngày Trước Quốc Khánh' => $independenceDay->subDay()];
        }

        if ($independenceDay->dayOfWeek == CarbonImmutable::SUNDAY) {
            return ['Ngày Sau Quốc Khánh' => $independenceDay->addDays(2)];
        }

        return [];
    }
}
