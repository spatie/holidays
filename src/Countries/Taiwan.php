<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Spatie\Holidays\Holiday;

/**
 * DGPA government-office holidays for 2020-2027, including adjusted days off but not
 * ordinary weekends or make-up working days. This is not a private-sector calendar.
 * Other years retain the incomplete legacy calculation for backwards compatibility.
 *
 * @see https://data.gov.tw/dataset/14718
 * @see https://law.moj.gov.tw/LawClass/LawAll.aspx?pcode=D0020095
 */
class Taiwan extends Country
{
    protected string $timezone = 'Asia/Taipei';

    /** @var array<int, array<int, array{string, string}>> */
    protected const array OFFICIAL_CALENDAR = [
        2020 => [
            ['01-01', '元旦'],
            ['01-23', '調整放假'],
            ['01-24', '農曆除夕'],
            ['01-25', '農曆春節-正月初一'],
            ['01-26', '農曆春節-正月初二'],
            ['01-27', '農曆春節-正月初三'],
            ['01-28', '補假'],
            ['01-29', '補假'],
            ['02-28', '228和平紀念日'],
            ['04-02', '補假'],
            ['04-03', '放假'],
            ['04-04', '兒童節'],
            ['04-04', '民族掃墓節'],
            ['06-25', '端午節'],
            ['06-26', '調整放假'],
            ['10-01', '中秋節'],
            ['10-02', '調整放假'],
            ['10-09', '補假'],
            ['10-10', '雙十國慶'],
        ],
        2021 => [
            ['01-01', '元旦'],
            ['02-10', '調整放假'],
            ['02-11', '農曆除夕'],
            ['02-12', '農曆春節-正月初一'],
            ['02-13', '農曆春節-正月初二'],
            ['02-14', '農曆春節-正月初三'],
            ['02-15', '補假'],
            ['02-16', '補假'],
            ['02-28', '228和平紀念日'],
            ['03-01', '補假'],
            ['04-02', '補假'],
            ['04-04', '兒童節'],
            ['04-04', '民族掃墓節'],
            ['04-05', '補假'],
            ['06-14', '端午節'],
            ['09-20', '調整放假'],
            ['09-21', '中秋節'],
            ['10-10', '雙十國慶'],
            ['10-11', '補假'],
            ['12-31', '補假'],
        ],
        2022 => [
            ['01-01', '元旦'],
            ['01-31', '農曆除夕'],
            ['02-01', '農曆春節-正月初一'],
            ['02-02', '農曆春節-正月初二'],
            ['02-03', '農曆春節-正月初三'],
            ['02-04', '調整放假'],
            ['02-28', '228和平紀念日'],
            ['04-04', '兒童節'],
            ['04-05', '民族掃墓節'],
            ['06-03', '端午節'],
            ['09-09', '補假'],
            ['09-10', '中秋節'],
            ['10-10', '雙十國慶'],
        ],
        2023 => [
            ['01-01', '元旦'],
            ['01-02', '補假'],
            ['01-20', '小年夜'],
            ['01-21', '農曆除夕'],
            ['01-22', '農曆春節-正月初一'],
            ['01-23', '農曆春節-正月初二'],
            ['01-24', '農曆春節-正月初三'],
            ['01-25', '補假'],
            ['01-26', '補假'],
            ['01-27', '調整放假'],
            ['02-27', '調整放假'],
            ['02-28', '228和平紀念日'],
            ['04-03', '調整放假'],
            ['04-04', '兒童節'],
            ['04-05', '民族掃墓節'],
            ['06-22', '端午節'],
            ['06-23', '調整放假'],
            ['09-29', '中秋節'],
            ['10-09', '調整放假'],
            ['10-10', '雙十國慶'],
        ],
        2024 => [
            ['01-01', '元旦'],
            ['02-08', '小年夜'],
            ['02-09', '農曆除夕'],
            ['02-10', '農曆春節-正月初一'],
            ['02-11', '農曆春節-正月初二'],
            ['02-12', '農曆春節-正月初三'],
            ['02-13', '補假'],
            ['02-14', '補假'],
            ['02-28', '228和平紀念日'],
            ['04-04', '兒童節'],
            ['04-04', '民族掃墓節'],
            ['04-05', '補假'],
            ['06-10', '端午節'],
            ['09-17', '中秋節'],
            ['10-10', '雙十國慶'],
        ],
        2025 => [
            ['01-01', '元旦'],
            ['01-27', '小年夜'],
            ['01-28', '農曆除夕'],
            ['01-29', '農曆春節-正月初一'],
            ['01-30', '農曆春節-正月初二'],
            ['01-31', '農曆春節-正月初三'],
            ['02-28', '228和平紀念日'],
            ['04-03', '補假'],
            ['04-04', '兒童節'],
            ['04-04', '民族掃墓節'],
            ['05-30', '補假'],
            ['05-31', '端午節'],
            ['09-28', '孔子誕辰紀念日'],
            ['09-29', '補假'],
            ['10-06', '中秋節'],
            ['10-10', '雙十國慶'],
            ['10-24', '補假'],
            ['10-25', '臺灣光復暨金門古寧頭大捷紀念日'],
            ['12-25', '行憲紀念日'],
        ],
        2026 => [
            ['01-01', '元旦'],
            ['02-15', '小年夜'],
            ['02-16', '農曆除夕'],
            ['02-17', '農曆春節-正月初一'],
            ['02-18', '農曆春節-正月初二'],
            ['02-19', '農曆春節-正月初三'],
            ['02-20', '補假'],
            ['02-27', '補假'],
            ['02-28', '228和平紀念日'],
            ['04-03', '補假'],
            ['04-04', '兒童節'],
            ['04-05', '清明節'],
            ['04-06', '補假'],
            ['05-01', '勞動節'],
            ['06-19', '端午節'],
            ['09-25', '中秋節'],
            ['09-28', '孔子誕辰紀念日/教師節'],
            ['10-09', '補假'],
            ['10-10', '雙十國慶'],
            ['10-25', '臺灣光復暨金門古寧頭大捷紀念日'],
            ['10-26', '補假'],
            ['12-25', '行憲紀念日'],
        ],
        2027 => [
            ['01-01', '元旦'],
            ['02-04', '小年夜'],
            ['02-05', '農曆除夕'],
            ['02-06', '農曆春節-正月初一'],
            ['02-07', '農曆春節-正月初二'],
            ['02-08', '農曆春節-正月初三'],
            ['02-09', '補假'],
            ['02-10', '補假'],
            ['02-28', '228和平紀念日'],
            ['03-01', '補假'],
            ['04-04', '兒童節'],
            ['04-05', '清明節'],
            ['04-06', '補假'],
            ['04-30', '補假'],
            ['05-01', '勞動節'],
            ['06-09', '端午節'],
            ['09-15', '中秋節'],
            ['09-28', '孔子誕辰紀念日/教師節'],
            ['10-10', '雙十國慶'],
            ['10-11', '補假'],
            ['10-25', '臺灣光復暨金門古寧頭大捷紀念日'],
            ['12-24', '補假'],
            ['12-25', '行憲紀念日'],
            ['12-31', '補假'],
        ],
    ];

    public function countryCode(): string
    {
        return 'tw';
    }

    protected function allHolidays(int $year): array
    {
        if (isset(self::OFFICIAL_CALENDAR[$year])) {
            $observedNames = ['補假', '調整放假', '放假'];

            // 小年夜 became statutory in May 2025, after that year's Lunar New Year.
            if ($year < 2026) {
                $observedNames[] = '小年夜';
            }

            return array_map(
                static fn (array $holiday): Holiday => in_array($holiday[1], $observedNames, true)
                    ? Holiday::observed($holiday[1], "{$year}-{$holiday[0]}")
                    : Holiday::national($holiday[1], "{$year}-{$holiday[0]}"),
                self::OFFICIAL_CALENDAR[$year],
            );
        }

        return array_merge([
            Holiday::national('元旦', "{$year}-01-01"),
            Holiday::national('228和平紀念日', "{$year}-02-28"),
            Holiday::national('兒童節', "{$year}-04-04"),
            Holiday::national('雙十國慶', "{$year}-10-10"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $holidays = [];
        $dates = [
            '農曆春節-正月初一' => '01-01',
            '農曆春節-正月初二' => '01-02',
            '農曆春節-正月初三' => '01-03',
            '端午節' => '05-05',
            '中秋節' => '08-15',
        ];

        foreach ($dates as $name => $date) {
            $holidayDate = $this->lunarCalendar($date, $year);
            if ($holidayDate !== null) {
                $holidays[] = Holiday::national($name, $holidayDate);
            }
        }

        return $holidays;
    }

    protected function lunarCalendar(string $input, int $year): ?CarbonImmutable
    {
        $formatter = new IntlDateFormatter(
            locale: 'zh-TW@calendar=chinese',
            dateType: IntlDateFormatter::SHORT,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );

        $lunarDateStr = "{$year}-{$input}";
        $parsedTimestamp = $formatter->parse($lunarDateStr);

        if ($parsedTimestamp === false) {
            return null;
        }

        $dateTime = new DateTime;
        $dateTime->setTimestamp((int) $parsedTimestamp);
        $dateTime->setTimezone(new DateTimeZone($this->timezone));

        return new CarbonImmutable($dateTime->format('Y-m-d'));
    }
}
