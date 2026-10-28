<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonPeriod;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Contracts\Islamic;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\HolidayType;

class Morocco extends Country implements Islamic
{
    use IslamicCalendar;

    /**
     * Morocco sets the start of each Hijri month by naked-eye moon sighting, announced by the
     * Ministry of Habous and Islamic Affairs, so these dates cannot be calculated and often
     * differ by a day from other countries. They are the officially announced dates. For years
     * that are not listed yet, an estimate is calculated from the tabular Islamic calendar
     * (it can be a day off) until the official dates are announced and added here.
     *
     * @return array<int, string>
     */
    protected function eidAlFitrDates(): array
    {
        return [
            2023 => '04-21',
            2024 => '04-10',
            2025 => '03-31',
            2026 => '03-20',
        ];
    }

    /** @return array<int, string> */
    protected function eidAlAdhaDates(): array
    {
        return [
            2023 => '06-29',
            2024 => '06-17',
            2025 => '06-07',
            2026 => '05-27',
        ];
    }

    /** @return array<int, string> */
    protected function islamicNewYearDates(): array
    {
        return [
            2023 => '07-19',
            2024 => '07-07',
            2025 => '06-27',
            2026 => '06-17',
        ];
    }

    /** @return array<int, string> */
    protected function prophetMuhammadBirthdayDates(): array
    {
        return [
            2023 => '09-28',
            2024 => '09-16',
            2025 => '09-05',
            2026 => '08-25',
        ];
    }

    public function countryCode(): string
    {
        return 'ma';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = [
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Proclamation of Independence Day', "{$year}-01-11"),
            Holiday::national('Amazigh New Year (ⵉⴹ ⵏ ⵢⵉⵏⵏⴰⵢⵔ)', "{$year}-01-14"),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::national('Throne Day', "{$year}-07-30"),
            Holiday::national('Oued Ed-Dahab Day', "{$year}-08-14"),
            Holiday::national('Revolution Day', "{$year}-08-20"),
            Holiday::national('Youth Day', "{$year}-08-21"),
            Holiday::national('Green March', "{$year}-11-06"),
            Holiday::national('Independence Day', "{$year}-11-18"),
        ];

        if ($year >= 2025) {
            $holidays[] = Holiday::national('Unity Day', "{$year}-10-31");
        }

        return array_merge($holidays, $this->islamicHolidays($year));
    }

    /** @return array<Holiday> */
    public function islamicHolidays(int $year): array
    {
        $newYear = $this->holidayPeriod($this->islamicNewYearDates(), $year, '01-01', 1, nextYear: true);
        $mawlid = $this->holidayPeriod($this->prophetMuhammadBirthdayDates(), $year, '03-12', 2, nextYear: true);
        $eidAlFitr = $this->holidayPeriod($this->eidAlFitrDates(), $year, '10-01', 2);
        $eidAlAdha = $this->holidayPeriod($this->eidAlAdhaDates(), $year, '12-10', 2);

        return array_merge(
            $this->convertPeriods('Islamic New Year', $year, $newYear, type: HolidayType::Religious),
            $this->convertPeriods('Birthday of the Prophet Muhammad', $year, $mawlid, type: HolidayType::Religious),
            $this->convertPeriods('Eid al-Fitr', $year, $eidAlFitr, type: HolidayType::Religious),
            $this->convertPeriods('Eid al-Adha', $year, $eidAlAdha, type: HolidayType::Religious),
        );
    }

    /** @param array<int, string> $officialDates */
    private function holidayPeriod(array $officialDates, int $year, string $hijriDate, int $totalDays, bool $nextYear = false): CarbonPeriod
    {
        if (isset($officialDates[$year])) {
            return $this->createPeriod($officialDates[$year], $year, $totalDays);
        }

        $start = $this->islamicToGregorianDate($hijriDate, $year, $nextYear)->startOfDay();

        return CarbonPeriod::create($start, '1 day', $start->addDays($totalDays - 1));
    }
}
