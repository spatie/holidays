<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Exceptions\InvalidYear;

class Bahrain extends Country
{
    protected const EID_AL_FITR_HOLIDAYS = [
        2020 => '05-24',
        2021 => '05-13',
        2022 => '05-02',
        2023 => '04-20',
        2024 => '04-10',
        2025 => '03-31',
        2026 => '03-21',
        2027 => '03-10',
        2028 => '02-27',
        2029 => '02-15',
        2030 => '02-04',
        2031 => '01-25',
        2032 => '01-15',
        2033 => '01-03',
        2034 => '12-13',
        2035 => '12-02',
        2036 => '11-20',
        2037 => '11-09',
    ];

    protected const ARAFAT_DAY_HOLIDAYS = [
        2020 => '07-30',
        2021 => '07-19',
        2022 => '07-09',
        2023 => '06-27',
        2024 => '06-16',
        2025 => '06-06',
        2026 => '05-26',
        2027 => '05-16',
        2028 => '05-05',
        2029 => '04-24',
        2030 => '04-13',
        2031 => '04-02',
        2032 => '03-21',
        2033 => '03-11',
        2034 => '03-01',
        2035 => '02-18',
        2036 => '02-07',
        2037 => '01-26',
    ];

    protected const EID_AL_ADHA_HOLIDAYS = [
        2020 => '07-31',
        2021 => '07-20',
        2022 => '07-09',
        2023 => '06-28',
        2024 => '06-17',
        2025 => '06-07',
        2026 => '05-27',
        2027 => '05-17',
        2028 => '05-06',
        2029 => '04-25',
        2030 => '04-14',
        2031 => '04-03',
        2032 => '03-22',
        2033 => '03-12',
        2034 => '03-02',
        2035 => '02-19',
        2036 => '02-08',
        2037 => '01-27',
    ];

    protected const ISLAMIC_NEW_YEAR_HOLIDAYS = [
        2020 => '08-20',
        2021 => '08-09',
        2022 => '07-30',
        2023 => '07-19',
        2024 => '07-08',
        2025 => '06-06',
        2026 => '06-17',
        2027 => '06-07',
        2028 => '05-26',
        2029 => '05-15',
        2030 => '05-05',
        2031 => '04-24',
        2032 => '04-12',
        2033 => '04-01',
        2034 => '03-22',
        2035 => '03-12',
        2036 => '02-29',
        2037 => '02-17',
    ];

    protected const ASHURA_HOLIDAYS = [
        2020 => '08-30',
        2021 => '08-19',
        2022 => '08-08',
        2023 => '07-28',
        2024 => '07-17',
        2025 => '07-07',
        2026 => '06-26',
        2027 => '06-15',
        2028 => '06-04',
        2029 => '05-24',
        2030 => '05-13',
        2031 => '05-02',
        2032 => '04-20',
        2033 => '04-10',
        2034 => '03-30',
        2035 => '03-19',
        2036 => '03-08',
        2037 => '02-25',
    ];

    protected const PROPHET_MUHAMMAD_BIRTHDAY_HOLIDAYS = [
        2020 => '10-29',
        2021 => '10-21',
        2022 => '10-08',
        2023 => '09-28',
        2024 => '09-16',
        2025 => '09-06',
        2026 => '08-26',
        2027 => '08-15',
        2028 => '08-04',
        2029 => '07-25',
        2030 => '07-14',
        2031 => '07-03',
        2032 => '06-21',
        2033 => '06-10',
        2034 => '05-31',
        2035 => '05-21',
        2036 => '05-09',
        2037 => '04-29',
    ];

    public function countryCode(): string
    {
        return 'bh';
    }

    protected function allHolidays(int $year): array
    {
        $variableHolidays = $this->variableHolidays($year);

        return array_merge([
            'New Year\'s Day' => '1-1',
            'Labour Day' => '5-1',
            'National Day' => '12-16',
            'National Day 2' => '12-17',
        ], $variableHolidays);
    }

    /**
     * @return array<string, CarbonInterface>
     */
protected function variableHolidays(int $year): array
{
    $holidays = [
        ['EID_AL_FITR_HOLIDAYS', 'Eid al-Fitr', 3],
        ['EID_AL_ADHA_HOLIDAYS', 'Eid al-Adha', 3],
        ['ARAFAT_DAY_HOLIDAYS', 'Arafat Day'],
        ['ISLAMIC_NEW_YEAR_HOLIDAYS', 'Islamic New Year'],
        ['ASHURA_HOLIDAYS', 'Ashura', 2],
        ['PROPHET_MUHAMMAD_BIRTHDAY_HOLIDAYS', 'Birthday of the Prophet Muhammad']
    ];

    $dates = [];
    foreach ($holidays as $holiday) {
        $dates = array_merge($dates, $this->getIslamicHolidayDatesForYear(constant('self::' . $holiday[0]), $year, $holiday[1], $holiday[2] ?? 1));
    }

    return $dates;
}

    /**
     * Prepare holiday dates for the given year.
     *
     * @param  array<int, string>  $holidayDates  Array mapping years to dates.
     * @param  int  $year  The year for which to prepare holiday dates.
     * @param  string  $holidayName  The name of the holiday.
     * @param  int  $duration  The duration of the holiday in days.
     * @return array<string, CarbonImmutable> An array of holiday dates.
     */
    private function getIslamicHolidayDatesForYear(array $holidayDates, int $year, string $holidayName, int $duration = 1): array
    {
        $dates = [];

        if ($year < 2020) {
            throw InvalidYear::yearTooLow(2020);
        }

        if (! isset($holidayDates[$year])) {
            return $dates;
        }

        $startDay = CarbonImmutable::createFromFormat('Y-m-d', sprintf('%s-%s', $year, $holidayDates[$year]));

        if ($duration === 1) {
            // For single-day holidays, use the holiday name without "Day"
            $dates[$holidayName] = $startDay;
        } else {
            // For multi-day holidays, append "Day N" for the second day onwards
            for ($i = 0; $i < $duration; $i++) {
                $dayLabel = $i === 0 ? $holidayName : sprintf('%s Day %d', $holidayName, $i + 1);
                $dates[$dayLabel] = $startDay->addDays($i);
            }
        }

        return $dates;
    }



    /**
     * @return array<string, CarbonInterface>
     */
    private function adjustForWeekend(string $name, CarbonImmutable $date): array
    {
        $adjustedHolidays = [];

        // Explicitly define this logic to avoid timezone confusion on the CarbonInterface::next() method
        if ($date->isFriday() || $date->isSaturday()) {
            // If the holiday falls on a weekend (Friday or Saturday), it is observed on the following Sunday
            $adjustedHolidays['Day off for '.$name] = $date->next(CarbonInterface::SUNDAY);
        } elseif ($date->isSunday() || $date->isThursday()) {
            // If the holiday falls on a Sunday or Thursday, it is observed on the same day
            $adjustedHolidays[$name] = $date;
        } else {
            // If the holiday falls on a weekday (Monday, Tuesday, Wednesday), it is observed on the following Thursday
            $adjustedHolidays['Day off for '.$name] = $date->next(CarbonInterface::THURSDAY);
        }

        return $adjustedHolidays;
    }
}
