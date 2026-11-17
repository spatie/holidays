<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

/**
 * Holiday periods announced by the State Council for 2024-2027, each day under the name of its holiday.
 * A period includes the weekends and adjusted days off inside it. Make-up working days are not listed.
 *
 * @see https://english.www.gov.cn/policies/latestreleases/202611/06/content_WS6aed74dcc6d00ca5f9a0e22e.html
 * @see https://english.shanghai.gov.cn/en-NationalPublicHolidays/index.html
 */
class China extends Country
{
    protected const string NEW_YEARS_DAY = '元旦';

    protected const string SPRING_FESTIVAL = '春节';

    protected const string QINGMING_FESTIVAL = '清明节';

    protected const string LABOR_DAY = '劳动节';

    protected const string DRAGON_BOAT_FESTIVAL = '端午节';

    protected const string MID_AUTUMN_FESTIVAL = '中秋节';

    protected const string NATIONAL_DAY = '国庆节';

    protected const string NATIONAL_DAY_AND_MID_AUTUMN_FESTIVAL = '国庆节、中秋节';

    public function countryCode(): string
    {
        return 'cn';
    }

    protected function defaultLocale(): string
    {
        return 'zh';
    }

    protected function supportedYearRange(): array
    {
        return [2024, 2027];
    }

    /**
     * First and last day of each announced period.
     *
     * @return array<int, array<int, array{string, string, string}>>
     */
    protected function holidayPeriods(): array
    {
        return [
            2024 => [
                [self::NEW_YEARS_DAY, '01-01', '01-01'],
                [self::SPRING_FESTIVAL, '02-10', '02-17'],
                [self::QINGMING_FESTIVAL, '04-04', '04-06'],
                [self::LABOR_DAY, '05-01', '05-05'],
                [self::DRAGON_BOAT_FESTIVAL, '06-08', '06-10'],
                [self::MID_AUTUMN_FESTIVAL, '09-15', '09-17'],
                [self::NATIONAL_DAY, '10-01', '10-07'],
            ],
            2025 => [
                [self::NEW_YEARS_DAY, '01-01', '01-01'],
                [self::SPRING_FESTIVAL, '01-28', '02-04'],
                [self::QINGMING_FESTIVAL, '04-04', '04-06'],
                [self::LABOR_DAY, '05-01', '05-05'],
                [self::DRAGON_BOAT_FESTIVAL, '05-31', '06-02'],
                [self::NATIONAL_DAY_AND_MID_AUTUMN_FESTIVAL, '10-01', '10-08'],
            ],
            2026 => [
                [self::NEW_YEARS_DAY, '01-01', '01-03'],
                [self::SPRING_FESTIVAL, '02-15', '02-23'],
                [self::QINGMING_FESTIVAL, '04-04', '04-06'],
                [self::LABOR_DAY, '05-01', '05-05'],
                [self::DRAGON_BOAT_FESTIVAL, '06-19', '06-21'],
                [self::MID_AUTUMN_FESTIVAL, '09-25', '09-27'],
                [self::NATIONAL_DAY, '10-01', '10-07'],
            ],
            2027 => [
                [self::NEW_YEARS_DAY, '01-01', '01-03'],
                [self::SPRING_FESTIVAL, '02-05', '02-13'],
                [self::QINGMING_FESTIVAL, '04-03', '04-05'],
                [self::LABOR_DAY, '05-01', '05-05'],
                [self::DRAGON_BOAT_FESTIVAL, '06-09', '06-09'],
                [self::MID_AUTUMN_FESTIVAL, '09-15', '09-15'],
                [self::NATIONAL_DAY, '10-01', '10-07'],
            ],
        ];
    }

    /** @return array<Holiday> */
    protected function allHolidays(int $year): array
    {
        $holidays = [];

        foreach ($this->holidayPeriods()[$year] ?? [] as [$name, $start, $end]) {
            $date = CarbonImmutable::parse("{$year}-{$start}");
            $last = CarbonImmutable::parse("{$year}-{$end}");

            while ($date->lessThanOrEqualTo($last)) {
                $holidays[] = Holiday::national($name, $date);

                $date = $date->addDay();
            }
        }

        return $holidays;
    }
}
