<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

/**
 * Follows the holiday rules in effect since 2007; earlier years are not reproduced exactly.
 *
 * @see https://www8.cao.go.jp/chosei/shukujitsu/gaiyou.html
 */
class Japan extends Country
{
    public function countryCode(): string
    {
        return 'jp';
    }

    protected function allHolidays(int $year): array
    {
        $holidays = [
            Holiday::national('元日', "{$year}-01-01"),
            Holiday::national('建国記念の日', "{$year}-02-11"),
            Holiday::national('春分の日', $this->equinox($year, 3, 20.8431)),
            Holiday::national('昭和の日', "{$year}-04-29"),
            Holiday::national('憲法記念日', "{$year}-05-03"),
            Holiday::national('みどりの日', "{$year}-05-04"),
            Holiday::national('こどもの日', "{$year}-05-05"),
            Holiday::national('秋分の日', $this->equinox($year, 9, 23.2488)),
            Holiday::national('文化の日', "{$year}-11-03"),
            Holiday::national('勤労感謝の日', "{$year}-11-23"),
            ...$this->emperorsBirthday($year),
            ...$this->variableHolidays($year),
        ];

        if ($year >= 2016) {
            $holidays[] = Holiday::national('山の日', match ($year) {
                2020 => '2020-08-10',
                2021 => '2021-08-08',
                default => "{$year}-08-11",
            });
        }

        if ($year === 2019) {
            $holidays[] = Holiday::national('天皇の即位の日', '2019-05-01');
            $holidays[] = Holiday::national('即位礼正殿の儀の行われる日', '2019-10-22');
        }

        return [...$holidays, ...$this->additionalHolidays($holidays)];
    }

    /** Estimates for 1980–2099; official equinox dates are announced the preceding February. */
    protected function equinox(int $year, int $month, float $base): CarbonImmutable
    {
        $day = (int) floor($base + 0.242194 * ($year - 1980) - floor(($year - 1980) / 4));

        return CarbonImmutable::parse(sprintf('%d-%02d-%02d', $year, $month, $day));
    }

    /** @return array<Holiday> */
    protected function emperorsBirthday(int $year): array
    {
        return match (true) {
            $year <= 2018 => [Holiday::national('天皇誕生日', "{$year}-12-23")],
            $year === 2019 => [],
            default => [Holiday::national('天皇誕生日', "{$year}-02-23")],
        };
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [
            Holiday::national('成人の日', CarbonImmutable::parse("second monday of january {$year}")),
            Holiday::national('敬老の日', CarbonImmutable::parse("third monday of september {$year}")),
            Holiday::national('海の日', match ($year) {
                2020 => '2020-07-23',
                2021 => '2021-07-22',
                default => CarbonImmutable::parse("third monday of july {$year}"),
            }),
            Holiday::national($year >= 2020 ? 'スポーツの日' : '体育の日', match ($year) {
                2020 => '2020-07-24',
                2021 => '2021-07-23',
                default => CarbonImmutable::parse("second monday of october {$year}"),
            }),
        ];
    }

    /**
     * The days that the law adds to the national holidays: the days between two holidays (article 3(3))
     * and the substitute holidays for the holidays on a Sunday (article 3(2)).
     *
     * @param  array<Holiday>  $holidays
     * @return array<Holiday>
     */
    protected function additionalHolidays(array $holidays): array
    {
        $occupiedDates = array_map(
            static fn (Holiday $holiday): string => $holiday->date->toDateString(),
            $holidays,
        );

        $additionalHolidays = [];

        foreach ($holidays as $holiday) {
            $dayBetween = $holiday->date->addDay();

            if ($dayBetween->isSunday()) {
                continue;
            }

            if (in_array($dayBetween->toDateString(), $occupiedDates, true)) {
                continue;
            }

            if (! in_array($dayBetween->addDay()->toDateString(), $occupiedDates, true)) {
                continue;
            }

            $occupiedDates[] = $dayBetween->toDateString();
            $additionalHolidays[] = Holiday::observed('国民の休日', $dayBetween);
        }

        usort($holidays, static fn (Holiday $first, Holiday $second): int => $first->date <=> $second->date);

        foreach ($holidays as $holiday) {
            if (! $holiday->date->isSunday()) {
                continue;
            }

            $substituteDate = $holiday->date->addDay();

            while (in_array($substituteDate->toDateString(), $occupiedDates, true)) {
                $substituteDate = $substituteDate->addDay();
            }

            $occupiedDates[] = $substituteDate->toDateString();
            $additionalHolidays[] = Holiday::observed('振替休日', $substituteDate);
        }

        return $additionalHolidays;
    }
}
