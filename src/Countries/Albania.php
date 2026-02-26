<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Contracts\Islamic;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holiday;

class Albania extends Country implements Islamic
{
    use IslamicCalendar;

    /** @return non-empty-array<int, string> */
    protected function eidAlFitrDates(): array
    {
        return [
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
        ];
    }

    /** @return non-empty-array<int, string> */
    protected function eidAlAdhaDates(): array
    {
        return [
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
        ];
    }

    public function countryCode(): string
    {
        return 'al';
    }

    protected function supportedYearRange(): array
    {
        return [2024, 2034];
    }

    protected function defaultLocale(): string
    {
        return 'al';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Viti i Ri', "{$year}-01-01"),
            Holiday::national('Dita e Verës', "{$year}-03-14"),
            Holiday::national('Dita e Sulltan Nevruzit', "{$year}-03-22"),
            Holiday::national('Dita Ndërkombëtare e Punëtorëve', "{$year}-05-01"),
            Holiday::national('Dita e Shenjtërimit të Shenjt Terezës', "{$year}-09-05"),
            Holiday::national('Dita e Pavarësisë', "{$year}-11-28"),
            Holiday::national('Dita e Çlirimit', "{$year}-11-29"),
            Holiday::national('Dita Kombëtare e Rinisë', "{$year}-12-08"),
            Holiday::national('Krishtlindja', "{$year}-12-25"),
        ],
            $this->variableHolidays($year),
            $this->islamicHolidays($year),
        );
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [
            Holiday::national('E diela e Pashkëve Katolike', $this->easter($year)),
            Holiday::national('E diela e Pashkëve Ortodokse', $this->orthodoxEaster($year)),
        ];
    }

    public function islamicHolidays(int $year): array
    {
        /**
         * Provided until 2034 by qppstudio.net.
         * https://www.qppstudio.net/global-holidays-observances/eid-al-fitr-end-of-ramadan.htm
         */
        if ($year < 2024 || $year > 2034) {
            throw InvalidYear::range('Albania', 2024, 2034);
        }

        $dates = $this->eidAlFitrDates();
        $eidAlFitrDate = $dates[$year] ?? null;
        $dates = $this->eidAlAdhaDates();
        $eidAlAdhaDate = $dates[$year] ?? null;

        return [
            Holiday::religious('Dita e Bajramit të Madh', "{$year}-{$eidAlFitrDate}"),
            Holiday::religious('Dita e Kurban Bajramit', "{$year}-{$eidAlAdhaDate}"),
        ];
    }
}
