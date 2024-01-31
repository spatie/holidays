<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;

class Albania extends Country
{
    public function countryCode(): string
    {
        return 'al';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Viti i Ri' => '01-01',
            'Dita e Verës' => '03-14',
            'Dita e Sulltan Nevruzit' => '03-22',
            'Dita Ndërkombëtare e Punëtorëve' => '05-01',
            'Dita e Shenjtërimit të Shenjt Terezës' => '09-05',
            'Dita e Pavarësisë' => '11-28',
            'Dita e Çlirimit' => '11-29',
            'Dita Kombëtare e Rinisë' => '12-08',
            'Krishtlindja' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable|string> */
    protected function variableHolidays(int $year): array
    {
        return array_filter([
            'E diela e Pashkëve Katolike' => $this->easter($year),
            'E diela e Pashkëve Ortodokse' => $this->orthodoxEaster($year),
            'Dita e Bajramit të Madh' => $this->getEidAlFitrHoliday($year),
            'Dita e Kurban Bajramit' => $this->getEidAlAdhaHoliday($year),
        ]);
    }

    private function getEidAlFitrHoliday(int $year): string
    {
        /**
         * Provided until 2034 by qppstudio.net.
         * https://www.qppstudio.net/global-holidays-observances/eid-al-fitr-end-of-ramadan.htm
         */
        return match ($year) {
            2024 => '04-10',
            2025 => '03-30',
            2026 => '03-20',
            2027 => '03-09',
            2028 => '02-26',
            2029 => '02-14',
            2030 => '02-04',
            2031 => '01-24',
            2032 => '01-14',
            2033 => '01-02',
            2034 => '12-12',
            default => throw InvalidYear::range('Albania', 2024, 2034),
        };
    }

    private function getEidAlAdhaHoliday(int $year): string
    {
        /**
         * Tentative dates.
         * Provided until 2034 by timeanddate.com.
         * https://www.timeanddate.com/holidays/us/eid-al-adha
         */
        return match ($year) {
            2024 => '06-17',
            2025 => '06-07',
            2026 => '05-27',
            2027 => '05-17',
            2028 => '05-05',
            2029 => '04-24',
            2030 => '04-14',
            2031 => '04-03',
            2032 => '03-22',
            2033 => '03-12',
            2034 => '03-01',
            default => throw InvalidYear::range('Albania', 2024, 2034),
        };
    }
}
