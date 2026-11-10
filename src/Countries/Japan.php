<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

/**
 * National holidays of Japan under the Act on National Holidays (国民の祝日に関する法律).
 *
 * @see https://www8.cao.go.jp/chosei/shukujitsu/gaiyou.html Cabinet Office, with a list of every holiday as CSV
 *
 * The rules follow the law as it has stood since 2007, when the Greenery Day and Showa Day
 * moved to 4 May and 29 April and the rule for substitute holidays took its present form.
 * Earlier years are not reproduced exactly.
 *
 * - The equinox days (春分の日 and 秋分の日) are calculated, which holds for 1980 through 2099.
 *   They are announced in the official gazette in February of the previous year.
 * - Article 3(2): a holiday on a Sunday is followed by the nearest day that is not a holiday
 *   (振替休日).
 * - Article 3(3): a day between two holidays is a holiday as well (国民の休日).
 * - The Emperor's Birthday is 23 December until 2018, there is none in 2019 and it is 23 February
 *   from 2020.
 * - In 2019 the day of the accession (1 May) and the day of the enthronement ceremony (22 October)
 *   are holidays, by the Act on Holidays for the Day of the Emperor's Accession and the Day of the
 *   Enthronement Ceremony (平成30年法律第99号).
 * - Marine Day, Sports Day and Mountain Day were moved for the Tokyo Olympic Games in 2020 and 2021.
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
            Holiday::national('成人の日', CarbonImmutable::parse("second monday of january {$year}")),
            Holiday::national('建国記念の日', "{$year}-02-11"),
            Holiday::national('春分の日', $this->equinox($year, 3, 20.8431)),
            Holiday::national('昭和の日', "{$year}-04-29"),
            Holiday::national('憲法記念日', "{$year}-05-03"),
            Holiday::national('みどりの日', "{$year}-05-04"),
            Holiday::national('こどもの日', "{$year}-05-05"),
            Holiday::national('敬老の日', CarbonImmutable::parse("third monday of september {$year}")),
            Holiday::national('秋分の日', $this->equinox($year, 9, 23.2488)),
            Holiday::national('文化の日', "{$year}-11-03"),
            Holiday::national('勤労感謝の日', "{$year}-11-23"),
            ...$this->emperorsBirthday($year),
            ...$this->olympicHolidays($year),
        ];

        if ($year >= 2016 && ! in_array($year, [2020, 2021], true)) {
            $holidays[] = Holiday::national('山の日', "{$year}-08-11");
        }

        if (! in_array($year, [2020, 2021], true)) {
            $holidays[] = Holiday::national('海の日', CarbonImmutable::parse("third monday of july {$year}"));
            $holidays[] = Holiday::national(
                $year >= 2020 ? 'スポーツの日' : '体育の日',
                CarbonImmutable::parse("second monday of october {$year}"),
            );
        }

        if ($year === 2019) {
            $holidays[] = Holiday::national('天皇の即位の日', '2019-05-01');
            $holidays[] = Holiday::national('即位礼正殿の儀の行われる日', '2019-10-22');
        }

        return [...$holidays, ...$this->additionalHolidays($holidays)];
    }

    /** The Vernal and Autumnal Equinox Days, from the formula for 1980 through 2099. */
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
    protected function olympicHolidays(int $year): array
    {
        return match ($year) {
            2020 => [
                Holiday::national('海の日', '2020-07-23'),
                Holiday::national('スポーツの日', '2020-07-24'),
                Holiday::national('山の日', '2020-08-10'),
            ],
            2021 => [
                Holiday::national('海の日', '2021-07-22'),
                Holiday::national('スポーツの日', '2021-07-23'),
                Holiday::national('山の日', '2021-08-08'),
            ],
            default => [],
        };
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

            if (
                ! $dayBetween->isSunday()
                && ! in_array($dayBetween->toDateString(), $occupiedDates, true)
                && in_array($dayBetween->addDay()->toDateString(), $occupiedDates, true)
            ) {
                $occupiedDates[] = $dayBetween->toDateString();
                $additionalHolidays[] = Holiday::observed('国民の休日', $dayBetween);
            }
        }

        usort($holidays, static fn (Holiday $a, Holiday $b): int => $a->date <=> $b->date);

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
