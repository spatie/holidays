<?php

namespace Spatie\Holidays\Calendars;

/**
 * Nepal follows Bikram Sambat calendar. Bikram Sambat is a solar calendar based on ancient Hindu tradition. https://en.wikipedia.org/wiki/Vikram_Samvat
 *
 * Holiday in Nepal is celebrated according to the Bikram Sambat calendar, lunar calendar, and Gregorian calendar.
 */
trait NepaliCalendar
{
    public string $timezone = 'Asia/Kathmandu';

    /**
     * Celebrated on the first day of the Bikram Sambat calendar. (Baishakh - 01/01)
     */
    public const nepaliNewYear = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Nepali New Year',
        'dates' => [
            2024 => '04-13',
        ],
    ];

    /**
     * Celebrated on 15 Jestha - 02/15 of the Bikram Sambat calendar.
     */
    public const nationalRepublicDay = [
        'calendar' => 'Bikram Sambat',
        'label' => 'National Republic Day',
        'dates' => [
            2024 => '05-28',
        ],
    ];

    /**
     * Celebrated on 27 Paush - 09/27 of the Bikram Sambat calendar.
     */
    public const prithiviJayanti = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Prithivi Jayanti',
        'dates' => [
            2025 => '01-11',
        ],
    ];

    /**
     * Celebrated on 16 Magh - 10/16 of the Bikram Sambat calendar.
     */
    public const martyrsDay = [
        'calendar' => 'Bikram Sambat',
        'label' => "Martyrs' Day",
        'dates' => [
            2025 => '01-29',
        ],
    ];

    /**
     * Celebrated on 7 Falgun - 11/07 of the Bikram Sambat calendar.
     */
    public const democracyDay = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Democracy Day',
        'dates' => [
            2025 => '02-19',
        ],
    ];

    /**
     * Celebrated on 3 Ashwin - 04/03 of the Bikram Sambat calendar.
     */
    public const constitutionDay = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Constitution Day',
        'dates' => [
            2024 => '09-19',
        ],
    ];

    /**
     * Celebrated on 1 Magh - 10/01 of the Bikram Sambat calendar.
     */
    public const makarSankrantiHoliday = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Makar Sankranti',
        'dates' => [
            2025 => '01-14',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the first day of "Dashain" festival.
     */
    public const ghatasthapanaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Ghatasthapana (Dashain)',
        'dates' => [
            2024 => '10-03',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 7th day of "Dashain" festival.
     */
    public const fulpatiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Fulpati (Dashain)',
        'dates' => [
            2024 => '10-11',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 8th day of "Dashain" festival.
     */
    public const mahaNawamiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Maha Nawami (Dashain)',
        'dates' => [
            2024 => '10-12',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 9th day of "Dashain" festival.
     */
    public const mahaAsthamiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Maha Asthami (Dashain)',
        'dates' => [
            2024 => '10-12',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 10th day of "Dashain" festival.
     */
    public const vijayaDashamiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Vijaya Dashami (Dashain)',
        'dates' => [
            2024 => '10-13',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 11th day of "Dashain" festival.
     */
    public const ekadashiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Ekadashi (Dashain)',
        'dates' => [
            2024 => '10-14',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 3rd day of "Tihar" festival.
     */
    public const laxmiPujaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Laxmi Puja (Tihar)',
        'dates' => [
            2024 => '11-01',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 4th day of "Tihar" festival.
     */
    public const govardhanPujaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Govardhan Puja / Mha Puja (Tihar)',
        'dates' => [
            2024 => '11-02',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 5th day of "Tihar" festival.
     */
    public const bhaiTikaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Bhai Tika (Tihar)',
        'dates' => [
            2024 => '11-03',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Chhat Parva is a festival dedicated to the Sun God.
     */
    public const chhatParvaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Chhat Parva',
        'dates' => [
            2024 => '11-07',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Tamu Loshar is the New Year of the Gurung community.
     */
    public const tamuLosharHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Tamu Loshar',
        'dates' => [
            2024 => '12-30',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Sonam Losar is the New Year of the Tamang community.
     */
    public const sonamLosarHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Sonam Losar',
        'dates' => [
            2025 => '01-30',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Gyalpo Loshar is the New Year of the Sherpa community.
     */
    public const gyalpoLosharHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Gyalpo Loshar',
        'dates' => [
            2025 => '02-28',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Udhauli Parva is the festival of the Kirat community.
     */
    public const udhauliParvaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Udhauli Parva',
        'dates' => [
            2024 => '12-15',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Mahashivaratri is a Hindu festival dedicated to Lord Shiva.
     */
    public const mahashivaratriHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Maha Shivaratri',
        'dates' => [
            2025 => '02-26',
        ],
    ];

    public const holiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Holi / Fagu Purnima',
        'dates' => [
            2025 => '03-13',
        ],
    ];

    public function holidaysAccordingToBikramSambatCalendar(int $year): array
    {
        $holidays = [
            self::nepaliNewYear['label'] => self::nepaliNewYear['dates'][$year] ?? null,
            self::nationalRepublicDay['label'] => self::nationalRepublicDay['dates'][$year] ?? null,
            self::prithiviJayanti['label'] => self::prithiviJayanti['dates'][$year] ?? null,
            self::martyrsDay['label'] => self::martyrsDay['dates'][$year] ?? null,
            self::democracyDay['label'] => self::democracyDay['dates'][$year] ?? null,
            self::constitutionDay['label'] => self::constitutionDay['dates'][$year] ?? null,
            self::makarSankrantiHoliday['label'] => self::makarSankrantiHoliday['dates'][$year] ?? null,
        ];

        return array_filter($holidays, fn ($holiday) => $holiday !== null);
    }

    public function holidaysAccordingToLunarCalendar(int $year): array
    {
        $holidays = [
            self::ghatasthapanaHoliday['label'] => self::ghatasthapanaHoliday['dates'][$year] ?? null,
            self::fulpatiHoliday['label'] => self::fulpatiHoliday['dates'][$year] ?? null,
            self::mahaNawamiHoliday['label'] => self::mahaNawamiHoliday['dates'][$year] ?? null,
            self::mahaAsthamiHoliday['label'] => self::mahaAsthamiHoliday['dates'][$year] ?? null,
            self::vijayaDashamiHoliday['label'] => self::vijayaDashamiHoliday['dates'][$year] ?? null,
            self::ekadashiHoliday['label'] => self::ekadashiHoliday['dates'][$year] ?? null,
            self::laxmiPujaHoliday['label'] => self::laxmiPujaHoliday['dates'][$year] ?? null,
            self::govardhanPujaHoliday['label'] => self::govardhanPujaHoliday['dates'][$year] ?? null,
            self::bhaiTikaHoliday['label'] => self::bhaiTikaHoliday['dates'][$year] ?? null,
            self::chhatParvaHoliday['label'] => self::chhatParvaHoliday['dates'][$year] ?? null,
            self::tamuLosharHoliday['label'] => self::tamuLosharHoliday['dates'][$year] ?? null,
            self::sonamLosarHoliday['label'] => self::sonamLosarHoliday['dates'][$year] ?? null,
            self::gyalpoLosharHoliday['label'] => self::gyalpoLosharHoliday['dates'][$year] ?? null,
            self::udhauliParvaHoliday['label'] => self::udhauliParvaHoliday['dates'][$year] ?? null,
            self::mahashivaratriHoliday['label'] => self::mahashivaratriHoliday['dates'][$year] ?? null,
            self::holiHoliday['label'] => self::holiHoliday['dates'][$year] ?? null,
        ];

        return array_filter($holidays, fn ($holiday) => $holiday !== null);
    }

    /**
     * Holiday according to Gregorian calendar.
     *
     * @return array<string, string>
     */
    public function holidayAccordingToGregorianCalendar(): array
    {
        return [
            'International Labor Day' => '05-01',
            'Christmas' => '12-25',
        ];
    }
}
