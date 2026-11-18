<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\ResolvesCalendarDates;
use Spatie\Holidays\Holiday;

/**
 * Bank of Thailand holidays of financial institutions for 2022-2027, including special holidays
 * but not area-only holidays or government-office holidays that banks do not observe.
 * Names follow the Thai text of the announcements, which is the official version.
 *
 * @see https://www.bot.or.th/th/financial-institutions-holiday.html
 * @see https://www.bot.or.th/en/financial-institutions-holiday.html
 */
class Thailand extends Country
{
    use ResolvesCalendarDates;

    protected const string NEW_YEARS_DAY = 'วันขึ้นปีใหม่';

    protected const string MAKHA_BUCHA = 'วันมาฆบูชา';

    protected const string CHAKRI_MEMORIAL_DAY = 'วันพระบาทสมเด็จพระพุทธยอดฟ้าจุฬาโลกมหาราช และวันที่ระลึกมหาจักรีบรมราชวงศ์';

    protected const string SONGKRAN = 'วันสงกรานต์';

    protected const string LABOUR_DAY = 'วันแรงงานแห่งชาติ';

    protected const string CORONATION_DAY = 'วันฉัตรมงคล';

    protected const string VISAKHA_BUCHA = 'วันวิสาขบูชา';

    protected const string QUEEN_SUTHIDA_BIRTHDAY = 'วันเฉลิมพระชนมพรรษาสมเด็จพระนางเจ้าสุทิดา พัชรสุธาพิมลลักษณ พระบรมราชินี';

    protected const string ASARNHA_BUCHA = 'วันอาสาฬหบูชา';

    protected const string KING_BIRTHDAY = 'วันเฉลิมพระชนมพรรษาพระบาทสมเด็จพระเจ้าอยู่หัว';

    protected const string QUEEN_MOTHER_BIRTHDAY = 'วันเฉลิมพระชนมพรรษาสมเด็จพระนางเจ้าสิริกิติ์ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง และวันแม่แห่งชาติ';

    protected const string QUEEN_MOTHER_BIRTHDAY_ANNIVERSARY = 'วันคล้ายวันพระราชสมภพ สมเด็จพระนางเจ้าสิริกิติ์ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง และวันแม่แห่งชาติ';

    protected const string KING_BHUMIBOL_MEMORIAL_DAY = 'วันคล้ายวันสวรรคตพระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร';

    protected const string NAVAMINDRA_MAHARAJ_DAY = 'วันนวมินทรมหาราช';

    protected const string CHULALONGKORN_DAY = 'วันปิยมหาราช';

    protected const string KING_BHUMIBOL_BIRTHDAY = 'วันคล้ายวันพระบรมราชสมภพพระบาทสมเด็จพระบรมชนกาธิเบศร มหาภูมิพลอดุลยเดชมหาราช บรมนาถบพิตร วันชาติ และวันพ่อแห่งชาติ';

    protected const string CONSTITUTION_DAY = 'วันรัฐธรรมนูญ';

    protected const string NEW_YEARS_EVE = 'วันสิ้นปี';

    protected const string SUBSTITUTION_PREFIX = 'ชดเชย';

    protected const string SPECIAL_HOLIDAY = 'วันหยุดพิเศษ';

    public function countryCode(): string
    {
        return 'th';
    }

    protected function defaultLocale(): string
    {
        return 'th';
    }

    protected function supportedYearRange(): array
    {
        return [2022, 2027];
    }

    /** @return array<int, string> */
    protected function makhaBuchaDates(): array
    {
        return [
            2022 => '02-16',
            2023 => '03-06',
            2024 => '02-24',
            2025 => '02-12',
            2026 => '03-03',
            2027 => '02-21',
        ];
    }

    /** @return array<int, string> */
    protected function visakhaBuchaDates(): array
    {
        return [
            2022 => '05-15',
            2023 => '06-03',
            2024 => '05-22',
            2025 => '05-11',
            2026 => '05-31',
            2027 => '05-20',
        ];
    }

    /** @return array<int, string> */
    protected function asarnhaBuchaDates(): array
    {
        return [
            2022 => '07-13',
            2023 => '08-01',
            2024 => '07-20',
            2025 => '07-10',
            2026 => '07-29',
            2027 => '07-18',
        ];
    }

    /**
     * Announced substitution days; one day can stand in for two holidays.
     *
     * @return array<int, array<string, string>>
     */
    protected function substitutionDays(): array
    {
        return [
            2022 => [
                '01-03' => self::NEW_YEARS_DAY,
                '05-02' => self::LABOUR_DAY,
                '05-16' => self::VISAKHA_BUCHA,
                '10-24' => self::CHULALONGKORN_DAY,
                '12-12' => self::CONSTITUTION_DAY,
            ],
            2023 => [
                '01-02' => 'วันสิ้นปีและวันขึ้นปีใหม่',
                '06-05' => self::QUEEN_SUTHIDA_BIRTHDAY.' และวันวิสาขบูชา',
                '08-14' => self::QUEEN_MOTHER_BIRTHDAY,
                '12-11' => self::CONSTITUTION_DAY,
                '12-29' => self::NEW_YEARS_EVE,
            ],
            2024 => [
                '02-26' => self::MAKHA_BUCHA,
                '04-08' => self::CHAKRI_MEMORIAL_DAY,
                '04-16' => self::SONGKRAN,
                '05-06' => self::CORONATION_DAY,
                '07-22' => self::ASARNHA_BUCHA,
                '07-29' => self::KING_BIRTHDAY,
                '10-14' => self::NAVAMINDRA_MAHARAJ_DAY,
            ],
            2025 => [
                '04-07' => self::CHAKRI_MEMORIAL_DAY,
                '05-05' => self::CORONATION_DAY,
                '05-12' => self::VISAKHA_BUCHA,
            ],
            2026 => [
                '06-01' => self::VISAKHA_BUCHA,
                '12-07' => self::KING_BHUMIBOL_BIRTHDAY,
            ],
            2027 => [
                '02-22' => self::MAKHA_BUCHA,
                '05-03' => self::LABOUR_DAY,
                '07-19' => self::ASARNHA_BUCHA,
                '10-25' => self::CHULALONGKORN_DAY,
                '12-06' => self::KING_BHUMIBOL_BIRTHDAY,
            ],
        ];
    }

    /**
     * Weekend holidays without a substitution day, which no announcement names.
     *
     * @return array<int, array<string>>
     */
    protected function unannouncedWeekendHolidays(): array
    {
        return [
            2023 => ['04-15'],
            2025 => ['04-13'],
        ];
    }

    /** @return array<int, array<string>> */
    protected function additionalSpecialHolidays(): array
    {
        return [
            2022 => ['07-29', '10-14'],
            2023 => ['05-05'],
            2024 => ['04-12'],
            2025 => ['06-02', '08-11'],
            2026 => ['01-02', '12-16'],
            2027 => [],
        ];
    }

    /** @return array<Holiday> */
    protected function allHolidays(int $year): array
    {
        $holidays = [
            Holiday::national(self::NEW_YEARS_DAY, "{$year}-01-01"),
            Holiday::religious(self::MAKHA_BUCHA, $this->getSingleDayHoliday($this->makhaBuchaDates(), $year)),
            Holiday::national(self::CHAKRI_MEMORIAL_DAY, "{$year}-04-06"),
            Holiday::national(self::SONGKRAN, "{$year}-04-13"),
            Holiday::national(self::SONGKRAN, "{$year}-04-14"),
            Holiday::national(self::SONGKRAN, "{$year}-04-15"),
            Holiday::national(self::LABOUR_DAY, "{$year}-05-01"),
            Holiday::national(self::CORONATION_DAY, "{$year}-05-04"),
            Holiday::religious(self::VISAKHA_BUCHA, $this->getSingleDayHoliday($this->visakhaBuchaDates(), $year)),
            Holiday::national(self::QUEEN_SUTHIDA_BIRTHDAY, "{$year}-06-03"),
            Holiday::religious(self::ASARNHA_BUCHA, $this->getSingleDayHoliday($this->asarnhaBuchaDates(), $year)),
            Holiday::national(self::KING_BIRTHDAY, "{$year}-07-28"),
            Holiday::national(
                $year < 2027 ? self::QUEEN_MOTHER_BIRTHDAY : self::QUEEN_MOTHER_BIRTHDAY_ANNIVERSARY,
                "{$year}-08-12",
            ),
            Holiday::national(
                $year < 2023 ? self::KING_BHUMIBOL_MEMORIAL_DAY : self::NAVAMINDRA_MAHARAJ_DAY,
                "{$year}-10-13",
            ),
            Holiday::national(self::CHULALONGKORN_DAY, "{$year}-10-23"),
            Holiday::national(self::KING_BHUMIBOL_BIRTHDAY, "{$year}-12-05"),
            Holiday::national(self::CONSTITUTION_DAY, "{$year}-12-10"),
            Holiday::national(self::NEW_YEARS_EVE, "{$year}-12-31"),
        ];

        $unannounced = $this->unannouncedWeekendHolidays()[$year] ?? [];

        $holidays = array_values(array_filter(
            $holidays,
            static fn (Holiday $holiday): bool => ! in_array($holiday->date->format('m-d'), $unannounced, true),
        ));

        foreach ($this->substitutionDays()[$year] ?? [] as $date => $name) {
            $holidays[] = Holiday::observed(self::SUBSTITUTION_PREFIX.$name, "{$year}-{$date}");
        }

        foreach ($this->additionalSpecialHolidays()[$year] ?? [] as $date) {
            $holidays[] = Holiday::national(self::SPECIAL_HOLIDAY, "{$year}-{$date}");
        }

        return $holidays;
    }
}
