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
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $nepaliNewYear = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Nepali New Year',
        'dates' => [
            2024 => '04-13',
        ],
    ];

    /**
     * Celebrated on 15 Jestha - 02/15 of the Bikram Sambat calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $nationalRepublicDay = [
        'calendar' => 'Bikram Sambat',
        'label' => 'National Republic Day',
        'dates' => [
            2024 => '05-28',
        ],
    ];

    /**
     * Celebrated on 27 Paush - 09/27 of the Bikram Sambat calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $prithiviJayanti = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Prithivi Jayanti',
        'dates' => [
            2025 => '01-11',
        ],
    ];

    /**
     * Celebrated on 16 Magh - 10/16 of the Bikram Sambat calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $martyrsDay = [
        'calendar' => 'Bikram Sambat',
        'label' => "Martyrs' Day",
        'dates' => [
            2025 => '01-29',
        ],
    ];

    /**
     * Celebrated on 7 Falgun - 11/07 of the Bikram Sambat calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $democracyDay = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Democracy Day',
        'dates' => [
            2025 => '02-19',
        ],
    ];

    /**
     * Celebrated on 3 Ashwin - 04/03 of the Bikram Sambat calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $constitutionDay = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Constitution Day',
        'dates' => [
            2024 => '09-19',
        ],
    ];

    /**
     * Celebrated on 1 Magh - 10/01 of the Bikram Sambat calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $makarSankrantiHoliday = [
        'calendar' => 'Bikram Sambat',
        'label' => 'Makar Sankranti',
        'dates' => [
            2025 => '01-14',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the first day of "Dashain" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $ghatasthapanaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Ghatasthapana (Dashain)',
        'dates' => [
            2024 => '10-03',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 7th day of "Dashain" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $fulpatiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Fulpati (Dashain)',
        'dates' => [
            2024 => '10-11',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 8th day of "Dashain" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $mahaNawamiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Maha Nawami (Dashain)',
        'dates' => [
            2024 => '10-12',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 9th day of "Dashain" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $mahaAsthamiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Maha Asthami (Dashain)',
        'dates' => [
            2024 => '10-12',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 10th day of "Dashain" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $vijayaDashamiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Vijaya Dashami (Dashain)',
        'dates' => [
            2024 => '10-13',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 11th day of "Dashain" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $ekadashiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Ekadashi (Dashain)',
        'dates' => [
            2024 => '10-14',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 3rd day of "Tihar" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $laxmiPujaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Laxmi Puja (Tihar)',
        'dates' => [
            2024 => '11-01',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 4th day of "Tihar" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $govardhanPujaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Govardhan Puja / Mha Puja (Tihar)',
        'dates' => [
            2024 => '11-02',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Celebrated on the 5th day of "Tihar" festival.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $bhaiTikaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Bhai Tika (Tihar)',
        'dates' => [
            2024 => '11-03',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Chhat Parva is a festival dedicated to the Sun God.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $chhatParvaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Chhat Parva',
        'dates' => [
            2024 => '11-07',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Tamu Loshar is the New Year of the Gurung community.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $tamuLosharHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Tamu Loshar',
        'dates' => [
            2024 => '12-30',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Sonam Losar is the New Year of the Tamang community.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $sonamLosarHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Sonam Losar',
        'dates' => [
            2025 => '01-30',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Gyalpo Loshar is the New Year of the Sherpa community.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $gyalpoLosharHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Gyalpo Loshar',
        'dates' => [
            2025 => '02-28',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Udhauli Parva is the festival of the Kirat community.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $udhauliParvaHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Udhauli Parva',
        'dates' => [
            2024 => '12-15',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar. Mahashivaratri is a Hindu festival dedicated to Lord Shiva.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $mahashivaratriHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Maha Shivaratri',
        'dates' => [
            2025 => '02-26',
        ],
    ];

    /**
     * Celebrated on according to lunar calendar.
     *
     * @var array{
     *     calendar: string,
     *     label: string,
     *     dates: array<int, string>
     * }
     */
    public array $holiHoliday = [
        'calendar' => 'Lunar Calendar',
        'label' => 'Holi / Fagu Purnima',
        'dates' => [
            2025 => '03-13',
        ],
    ];

    /**
     * Holidays according to Bikram Sambat calendar.
     *
     * @return array<string,string>
     */
    public function holidaysAccordingToBikramSambatCalendar(int $year): array
    {
        $holidays = [
            $this->nepaliNewYear['label'] => $this->nepaliNewYear['dates'][$year] ?? null,
            $this->nationalRepublicDay['label'] => $this->nationalRepublicDay['dates'][$year] ?? null,
            $this->prithiviJayanti['label'] => $this->prithiviJayanti['dates'][$year] ?? null,
            $this->martyrsDay['label'] => $this->martyrsDay['dates'][$year] ?? null,
            $this->democracyDay['label'] => $this->democracyDay['dates'][$year] ?? null,
            $this->constitutionDay['label'] => $this->constitutionDay['dates'][$year] ?? null,
            $this->makarSankrantiHoliday['label'] => $this->makarSankrantiHoliday['dates'][$year] ?? null,
        ];

        return array_filter($holidays, fn ($holiday) => $holiday !== null);
    }

    /**
     * Holidays according to lunar calendar.
     *
     * @return array<string,string>
     */
    public function holidaysAccordingToLunarCalendar(int $year): array
    {
        $holidays = [
            $this->ghatasthapanaHoliday['label'] => $this->ghatasthapanaHoliday['dates'][$year] ?? null,
            $this->fulpatiHoliday['label'] => $this->fulpatiHoliday['dates'][$year] ?? null,
            $this->mahaNawamiHoliday['label'] => $this->mahaNawamiHoliday['dates'][$year] ?? null,
            $this->mahaAsthamiHoliday['label'] => $this->mahaAsthamiHoliday['dates'][$year] ?? null,
            $this->vijayaDashamiHoliday['label'] => $this->vijayaDashamiHoliday['dates'][$year] ?? null,
            $this->ekadashiHoliday['label'] => $this->ekadashiHoliday['dates'][$year] ?? null,
            $this->laxmiPujaHoliday['label'] => $this->laxmiPujaHoliday['dates'][$year] ?? null,
            $this->govardhanPujaHoliday['label'] => $this->govardhanPujaHoliday['dates'][$year] ?? null,
            $this->bhaiTikaHoliday['label'] => $this->bhaiTikaHoliday['dates'][$year] ?? null,
            $this->chhatParvaHoliday['label'] => $this->chhatParvaHoliday['dates'][$year] ?? null,
            $this->tamuLosharHoliday['label'] => $this->tamuLosharHoliday['dates'][$year] ?? null,
            $this->sonamLosarHoliday['label'] => $this->sonamLosarHoliday['dates'][$year] ?? null,
            $this->gyalpoLosharHoliday['label'] => $this->gyalpoLosharHoliday['dates'][$year] ?? null,
            $this->udhauliParvaHoliday['label'] => $this->udhauliParvaHoliday['dates'][$year] ?? null,
            $this->mahashivaratriHoliday['label'] => $this->mahashivaratriHoliday['dates'][$year] ?? null,
            $this->holiHoliday['label'] => $this->holiHoliday['dates'][$year] ?? null,
        ];

        return array_filter($holidays, fn ($holiday) => $holiday !== null);
    }

    /**
     * Holiday according to Gregorian calendar.
     *
     * @return array<string,string>
     */
    public function holidayAccordingToGregorianCalendar(): array
    {
        return [
            'International Labor Day' => '05-01',
            'Christmas' => '12-25',
        ];
    }
}
