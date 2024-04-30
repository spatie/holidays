<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Contracts\Islamic;

class Bahrain extends Country implements HasTranslations, Islamic
{
    use IslamicCalendar;
    use Translatable;

    protected const eidAlFitr = [
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

    protected const arafat = [
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

    protected const eidAlAdha = [
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

    protected const islamicNewYear = [
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

    protected const ashura = [
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

    protected const prophetMuhammadBirthday = [
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

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '1-1',
            'Labour Day' => '5-1',
            'National Day' => '12-16',
            'National Day 2' => '12-17',
        ],
            $this->islamicHolidays($year)
        );
    }

    public function islamicHolidays(int $year): array
    {
        $eidAlFitr = $this->eidAlFitr($year);
        $eidAlAdha = $this->eidAlAdha($year, 3);
        $ashura = $this->ashura($year);

        $holidays = [
            'Arafat Day' => $this->arafat($year),
            'Islamic New Year' => $this->islamicNewYear($year),
            'Birthday of the Prophet Muhammad' => $this->prophetMuhammadBirthday($year),
        ];

        return array_merge($holidays,
            $this->convertPeriods('Eid al-Adha', $year, $eidAlAdha[0]),
            $this->convertPeriods('Eid al-Fitr', $year, $eidAlFitr[0]),
            $this->convertPeriods('Ashura', $year, $ashura[0]),
        );
    }
}
