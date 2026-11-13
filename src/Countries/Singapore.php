<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\ResolvesCalendarDates;
use Spatie\Holidays\Holiday;

/**
 * Scheduled public holidays for 2020-2027, excluding Polling Day and one-off declarations.
 * Announced dates use MOM's tables rather than calendar estimates. In particular,
 * ICU places Chinese New Year a day late in 2027.
 *
 * @see https://sso.agc.gov.sg/Act/HA1998
 * @see https://www.mom.gov.sg/employment-practices/public-holidays
 */
class Singapore extends Country
{
    use ResolvesCalendarDates;

    public function countryCode(): string
    {
        return 'sg';
    }

    protected function supportedYearRange(): array
    {
        return [2020, 2027];
    }

    /** @return array<int, string> The first day of Chinese New Year. */
    protected function chineseNewYearDates(): array
    {
        return [
            2020 => '01-25',
            2021 => '02-12',
            2022 => '02-01',
            2023 => '01-22',
            2024 => '02-10',
            2025 => '01-29',
            2026 => '02-17',
            2027 => '02-06',
        ];
    }

    /** @return array<int, string> */
    protected function hariRayaPuasaDates(): array
    {
        return [
            2020 => '05-24',
            2021 => '05-13',
            2022 => '05-03',
            2023 => '04-22',
            2024 => '04-10',
            2025 => '03-31',
            2026 => '03-21',
            2027 => '03-10',
        ];
    }

    /** @return array<int, string> */
    protected function hariRayaHajiDates(): array
    {
        return [
            2020 => '07-31',
            2021 => '07-20',
            2022 => '07-10',
            2023 => '06-29',
            2024 => '06-17',
            2025 => '06-07',
            2026 => '05-27',
            2027 => '05-17',
        ];
    }

    /** @return array<int, string> */
    protected function vesakDayDates(): array
    {
        return [
            2020 => '05-07',
            2021 => '05-26',
            2022 => '05-15',
            2023 => '06-02',
            2024 => '05-22',
            2025 => '05-12',
            2026 => '05-31',
            2027 => '05-20',
        ];
    }

    /** @return array<int, string> */
    protected function deepavaliDates(): array
    {
        return [
            2020 => '11-14',
            2021 => '11-04',
            2022 => '10-24',
            2023 => '11-12',
            2024 => '10-31',
            2025 => '10-20',
            2026 => '11-08',
            2027 => '10-28',
        ];
    }

    /** @return array<Holiday> */
    protected function allHolidays(int $year): array
    {
        $chineseNewYear = $this->getSingleDayHoliday($this->chineseNewYearDates(), $year);

        $holidays = [
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Chinese New Year', $chineseNewYear),
            Holiday::national('Chinese New Year Day 2', $chineseNewYear->addDay()),
            Holiday::religious('Good Friday', $this->easter($year)->subDays(2)),
            Holiday::religious('Hari Raya Puasa', $this->getSingleDayHoliday($this->hariRayaPuasaDates(), $year)),
            Holiday::national('Labour Day', "{$year}-05-01"),
            Holiday::religious('Vesak Day', $this->getSingleDayHoliday($this->vesakDayDates(), $year)),
            Holiday::religious('Hari Raya Haji', $this->getSingleDayHoliday($this->hariRayaHajiDates(), $year)),
            Holiday::national('National Day', "{$year}-08-09"),
            Holiday::religious('Deepavali', $this->getSingleDayHoliday($this->deepavaliDates(), $year)),
            Holiday::religious('Christmas Day', "{$year}-12-25"),
        ];

        return [...$holidays, ...$this->observedHolidays($holidays)];
    }

    /**
     * Section 4(2) adds the next non-holiday after a Sunday holiday, retaining the Sunday.
     *
     * @param  array<Holiday>  $holidays
     * @return array<Holiday>
     */
    protected function observedHolidays(array $holidays): array
    {
        $occupiedDates = array_map(
            static fn (Holiday $holiday): string => $holiday->date->toDateString(),
            $holidays,
        );

        $observedHolidays = [];

        foreach ($holidays as $holiday) {
            if (! $holiday->date->isSunday()) {
                continue;
            }

            $observedDate = $holiday->date->addDay();

            while (in_array($observedDate->toDateString(), $occupiedDates, true)) {
                $observedDate = $observedDate->addDay();
            }

            $occupiedDates[] = $observedDate->toDateString();

            $observedHolidays[] = Holiday::observed("{$holiday->name} (observed)", $observedDate);
        }

        return $observedHolidays;
    }
}
