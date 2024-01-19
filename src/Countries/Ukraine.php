<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Ukraine extends Country
{
    protected function __construct(
        public ?string $region = null
    ) {
    }

    public function countryCode(): string
    {
        return 'uk';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Новий Рік' => '01-01',
            'Міжнародний жіночий день' => '03-08',
            'День праці' => '05-01',
            'День пам\'яті та перемоги над нацизмом у Другій світовій війні 1939 – 1945 років' => '05-08',
            'День Конституції України' => '06-28',
            'День Української Державності' => '07-15',
            'День Незалежності України' => '08-24',
            'День захисників і захисниць України' => '10-01',
            'Різдво Христове' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp($this->orthodox_eastern($year))
            ->setTimezone('Europe/Kyiv');

        return [
            'Великодній Понеділок' => $easter->addDay(),
            'Трійця' => $easter->addDays(50),
        ];
    }


    protected function orthodox_eastern($year): string
    {
        /* Copy from https://php5.kiev.ua/php7/function.easter-date.html */

        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = floor(($d + $e + 114) / 31);
        $day = (($d + $e + 114) % 31) + 1;

        $de = mktime(0, 0, 0, $month, $day + 13, $year);

        return $de;
    }
}