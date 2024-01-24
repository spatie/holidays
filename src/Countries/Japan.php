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
            '元日' => '01-01', // New Year's Day
            '建国記念の日' => '02-11', // Foundation Day
            '天皇誕生日' => '02-23', // Emperor's Birthday
            '春分の日' => '03-20', // Vernal Equinox Day *Decided each year; rarely on 03-21
            '昭和の日' => '04-29', // Showa Day
            '憲法記念日' => '05-03', // Constitution Day
            'みどりの日' => '05-04', // Greenery Day
            'こどもの日' => '05-05', // Children's Day
            '山の日' => '08-11', // Mountain Day
            '秋分の日' => '09-23', // Autumnal Equinox Day  *Decided each year; rarely on 09-22
            '文化の日' => '11-03', // Culture Day
            '勤労感謝の日' => '11-23', // Labor Thanksgiving Day

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $comingOfAgeDay = (new CarbonImmutable("second monday of january $year")) // Coming of Age Day
            ->setTimezone('Asia/Tokyo');

        $oceansDay = (new CarbonImmutable("third monday of july $year")) // Ocean's Day
            ->setTimezone('Asia/Tokyo');

        $respectForTheAgedDay = (new CarbonImmutable("third monday of september $year")) // Respect for the Aged Day
            ->setTimezone('Asia/Tokyo');

        $sportsDay = (new CarbonImmutable("second monday of october $year")) // Sports Day
            ->setTimezone('Asia/Tokyo');

        $holidays = [
            '成人の日' => $comingOfAgeDay,
            '海の日' => $oceansDay,
            '敬老の日' => $respectForTheAgedDay,
            'スポーツの日' => $sportsDay,
        ];

        return $holidays;

    }
}
