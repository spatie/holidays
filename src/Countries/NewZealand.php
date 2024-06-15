<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Observable;

class NewZealand extends Country
{
    use Observable;

    public function countryCode(): string
    {
        return 'nz';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->observedHolidays($year),
            $this->variableHolidays($year),
        );
    }

    /** @return array<string, string|CarbonInterface> */
    protected function observedHolidays(int $year): array
    {
        //https://www.employment.govt.nz/leave-and-holidays/public-holidays/public-holidays-and-anniversary-dates/
        $holidays = [
            "New Year's Day" => '01-01',
            "Day after New Year's Day" => '01-02',
            'Waitangi Day' => '02-06',
            'ANZAC Day' => '04-25',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ];

        //https://www.employment.govt.nz/leave-and-holidays/public-holidays/public-holidays-falling-on-a-weekend/
        foreach ($holidays as $name => $date) {
            $observedDay = match ($name) {
                "Day after New Year's Day" => $this->secondOfJanuary($year),
                'Christmas Day' => $this->observedChristmasDay($year),
                'Boxing Day' => $this->observedBoxingDay($year),
                default => $this->weekendToNextMonday($date, $year),
            };

            if ($observedDay) {
                $holidays[$name.' (Mondayisation)'] = $observedDay;
                unset($holidays[$name]);
            }
        }

        return $holidays;
    }

    /** @return array<string, CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        //Easter
        $easterSunday = $this->easter($year);
        $goodFriday = $easterSunday->subDays(2);
        $easterMonday = $easterSunday->addDay();

        //Sovereign Birthday
        $sovereignTitle = $this->sovereignBirthdayKey($year);
        $sovereignMonday = CarbonImmutable::parse("first monday of june {$year}");

        //Labour Day
        $labourMonday = CarbonImmutable::parse("fourth monday of october {$year}");

        $holidays = [
            'Good Friday' => $goodFriday,
            'Easter Monday' => $easterMonday,
            $sovereignTitle => $sovereignMonday,
            'Labour Day' => $labourMonday,
        ];

        $matariki = $this->calculateMatariki($year);

        if ($matariki) {
            $holidays['Matariki'] = $matariki;
        }

        return $holidays;
    }

    protected function secondOfJanuary(int $year): ?CarbonInterface
    {
        $newYearsDay = (new CarbonImmutable($year.'-01-01'))->startOfDay();
        $secondOfJanuary = $newYearsDay->addDay();

        return match ($newYearsDay->dayName) {
            'Friday' => $secondOfJanuary->next('monday'),
            'Saturday', 'Sunday' => $secondOfJanuary->next('tuesday'),
            default => null,
        };
    }

    protected function sovereignBirthdayKey(int $year): string
    {
        return $year >= 2023 ? "King's Birthday" : "Queen's Birthday";
    }

    private function calculateMatariki(int $year): ?CarbonImmutable
    {
        //https://www.tepapa.govt.nz/discover-collections/read-watch-play/matariki-maori-new-year/dates-for-matariki-public-holiday
        $matarikiDates = [
            2022 => '2022-06-24',
            2023 => '2023-07-14',
            2024 => '2024-06-28',
            2025 => '2025-06-20',
            2026 => '2026-07-10',
            2027 => '2027-06-25',
            2028 => '2028-07-14',
            2029 => '2029-07-06',
            2030 => '2030-06-21',
            2031 => '2031-07-11',
            2032 => '2032-07-02',
            2033 => '2033-06-24',
            2034 => '2034-07-07',
            2035 => '2035-06-29',
            2036 => '2036-07-18',
            2037 => '2037-07-10',
            2038 => '2038-06-25',
            2039 => '2039-07-15',
            2040 => '2040-07-06',
            2041 => '2041-07-19',
            2042 => '2042-07-11',
            2043 => '2043-07-03',
            2044 => '2044-06-24',
            2045 => '2045-07-07',
            2046 => '2046-06-29',
            2047 => '2047-07-19',
            2048 => '2048-07-03',
            2049 => '2049-06-25',
            2050 => '2050-07-15',
            2051 => '2051-06-30',
            2052 => '2052-06-21',
        ];

        return isset($matarikiDates[$year])
        ? CarbonImmutable::createFromFormat('Y-m-d', $matarikiDates[$year])?->setTimezone('Pacific/Auckland')
        : null; // Return null if year not defined
    }
}
