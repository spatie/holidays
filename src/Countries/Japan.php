<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Japan extends Country
{
    public function countryCode(): string
    {
        return 'jp';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            '元日' => CarbonImmutable::createFromDate($year, 1, 1), // New Year's Day
            '建国記念の日' => CarbonImmutable::createFromDate($year, 2, 11), // Foundation Day
            '天皇誕生日' => CarbonImmutable::createFromDate($year, 2, 23), // Emperor's Birthday
            '春分の日' => CarbonImmutable::createFromDate($year, 3, 20), // Vernal Equinox Day *Decided each year; rarely on 03-21
            '昭和の日' => CarbonImmutable::createFromDate($year, 4, 29), // Showa Day
            '憲法記念日' => CarbonImmutable::createFromDate($year, 5, 3), // Constitution Day
            'みどりの日' => CarbonImmutable::createFromDate($year, 5, 4), // Greenery Day
            'こどもの日' => CarbonImmutable::createFromDate($year, 5, 5), // Children's Day
            '山の日' => CarbonImmutable::createFromDate($year, 8, 11), // Mountain Day
            '秋分の日' => CarbonImmutable::createFromDate($year, 9, 23), // Autumnal Equinox Day  *Decided each year; rarely on 09-22
            '文化の日' => CarbonImmutable::createFromDate($year, 11, 3), // Culture Day
            '勤労感謝の日' => CarbonImmutable::createFromDate($year, 11, 23), // Labor Thanksgiving Day

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return [
            '成人の日' => CarbonImmutable::parse('second monday of january '.$year),
            '海の日' => CarbonImmutable::parse('third monday of july '.$year),
            '敬老の日' => CarbonImmutable::parse('third monday of september '.$year),
            'スポーツの日' => CarbonImmutable::parse('second monday of october '.$year),
        ];
    }
}
