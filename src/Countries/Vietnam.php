<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Holiday;

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
            Holiday::national('Tết Dương Lịch', "{$year}-01-01"),
            Holiday::national('Ngày Giải Phóng Miền Nam, Thống Nhất Đất Nước', "{$year}-04-30"),
            Holiday::national('Ngày Quốc Tế Lao Động', "{$year}-05-01"),
            Holiday::national('Ngày Quốc Khánh', "{$year}-09-02"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone('Asia/Ho_Chi_Minh');

        return array_merge(
            $this->getHungKingsFestival($year),
            $this->getLunarNewYearHoliday($year),
            $this->getTheExtraDayForIndependenceDay($year),
        );
    }

    /** @return array<Holiday> */
    protected function getHungKingsFestival(int $year): array
    {
        return [
            Holiday::national('Ngày Giỗ Tổ Hùng Vương', $this->chineseToGregorianDate('03-10', $year)),
        ];
    }

    /** @return array<Holiday> */
    protected function getLunarNewYearHoliday(int $year): array
    {
        $firstOfJanInChineseCalendar = $this->chineseToGregorianDate('01-01', $year);

        return [
            Holiday::national('Ngày Hai Mươi Chín Tết', $firstOfJanInChineseCalendar->subDays(2)),
            Holiday::national('Ngày Ba Mươi Tết', $firstOfJanInChineseCalendar->subDay()),
            Holiday::national('Mùng Một Tết Âm Lịch', $firstOfJanInChineseCalendar),
            Holiday::national('Mùng Hai Tết Âm Lịch', $firstOfJanInChineseCalendar->addDay()),
            Holiday::national('Mùng Ba Tết Âm Lịch', $firstOfJanInChineseCalendar->addDays(2)),
            Holiday::national('Mùng Bốn Tết Âm Lịch', $firstOfJanInChineseCalendar->addDays(3)),
            Holiday::national('Mùng Năm Tết Âm Lịch', $firstOfJanInChineseCalendar->addDays(4)),
        ];
    }

    /** @return array<Holiday> */
    protected function getTheExtraDayForIndependenceDay(int $year): array
    {
        if ($year < 2021) {
            return [];
        }

        $independenceDay = CarbonImmutable::parse("{$year}-09-02")->startOfDay();

        if ($independenceDay->dayOfWeek === CarbonInterface::MONDAY) {
            return [Holiday::national('Ngày Sau Quốc Khánh', $independenceDay->addDay())];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::TUESDAY) {
            return [Holiday::national('Ngày Trước Quốc Khánh', $independenceDay->subDay())];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::WEDNESDAY) {
            return [Holiday::national('Ngày Trước Quốc Khánh', $independenceDay->subDay())];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::THURSDAY) {
            return [Holiday::national('Ngày Sau Quốc Khánh', $independenceDay->addDay())];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::FRIDAY) {
            return [Holiday::national('Ngày Trước Quốc Khánh', $independenceDay->subDay())];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::SATURDAY) {
            return [Holiday::national('Ngày Trước Quốc Khánh', $independenceDay->subDay())];
        }

        if ($independenceDay->dayOfWeek === CarbonInterface::SUNDAY) {
            return [Holiday::national('Ngày Sau Quốc Khánh', $independenceDay->addDays(2))];
        }

        return [];
    }
}
