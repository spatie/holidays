<?php

namespace Spatie\Holidays\Calendars;

use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Holiday;

/**
 * Nepal follows Bikram Sambat calendar. Bikram Sambat is a solar calendar based on ancient Hindu tradition. https://en.wikipedia.org/wiki/Vikram_Samvat
 *
 * Holiday in Nepal is celebrated according to the Bikram Sambat calendar, lunar calendar, and Gregorian calendar.
 *
 * @mixin Country
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
     * @return array<Holiday>
     */
    public function holidaysAccordingToBikramSambatCalendar(int $year): array
    {
        $holidays = [];

        if (isset($this->nepaliNewYear['dates'][$year])) {
            $holidays[] = Holiday::religious($this->nepaliNewYear['label'], "{$year}-".$this->nepaliNewYear['dates'][$year]);
        }
        if (isset($this->nationalRepublicDay['dates'][$year])) {
            $holidays[] = Holiday::national($this->nationalRepublicDay['label'], "{$year}-".$this->nationalRepublicDay['dates'][$year]);
        }
        if (isset($this->prithiviJayanti['dates'][$year])) {
            $holidays[] = Holiday::national($this->prithiviJayanti['label'], "{$year}-".$this->prithiviJayanti['dates'][$year]);
        }
        if (isset($this->martyrsDay['dates'][$year])) {
            $holidays[] = Holiday::national($this->martyrsDay['label'], "{$year}-".$this->martyrsDay['dates'][$year]);
        }
        if (isset($this->democracyDay['dates'][$year])) {
            $holidays[] = Holiday::national($this->democracyDay['label'], "{$year}-".$this->democracyDay['dates'][$year]);
        }
        if (isset($this->constitutionDay['dates'][$year])) {
            $holidays[] = Holiday::national($this->constitutionDay['label'], "{$year}-".$this->constitutionDay['dates'][$year]);
        }
        if (isset($this->makarSankrantiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->makarSankrantiHoliday['label'], "{$year}-".$this->makarSankrantiHoliday['dates'][$year]);
        }

        return $holidays;
    }

    /**
     * Holidays according to lunar calendar.
     *
     * @return array<Holiday>
     */
    public function holidaysAccordingToLunarCalendar(int $year): array
    {
        $holidays = [];

        if (isset($this->ghatasthapanaHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->ghatasthapanaHoliday['label'], "{$year}-".$this->ghatasthapanaHoliday['dates'][$year]);
        }
        if (isset($this->fulpatiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->fulpatiHoliday['label'], "{$year}-".$this->fulpatiHoliday['dates'][$year]);
        }
        if (isset($this->mahaNawamiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->mahaNawamiHoliday['label'], "{$year}-".$this->mahaNawamiHoliday['dates'][$year]);
        }
        if (isset($this->mahaAsthamiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->mahaAsthamiHoliday['label'], "{$year}-".$this->mahaAsthamiHoliday['dates'][$year]);
        }
        if (isset($this->vijayaDashamiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->vijayaDashamiHoliday['label'], "{$year}-".$this->vijayaDashamiHoliday['dates'][$year]);
        }
        if (isset($this->ekadashiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->ekadashiHoliday['label'], "{$year}-".$this->ekadashiHoliday['dates'][$year]);
        }
        if (isset($this->laxmiPujaHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->laxmiPujaHoliday['label'], "{$year}-".$this->laxmiPujaHoliday['dates'][$year]);
        }
        if (isset($this->govardhanPujaHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->govardhanPujaHoliday['label'], "{$year}-".$this->govardhanPujaHoliday['dates'][$year]);
        }
        if (isset($this->bhaiTikaHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->bhaiTikaHoliday['label'], "{$year}-".$this->bhaiTikaHoliday['dates'][$year]);
        }
        if (isset($this->chhatParvaHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->chhatParvaHoliday['label'], "{$year}-".$this->chhatParvaHoliday['dates'][$year]);
        }
        if (isset($this->tamuLosharHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->tamuLosharHoliday['label'], "{$year}-".$this->tamuLosharHoliday['dates'][$year]);
        }
        if (isset($this->sonamLosarHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->sonamLosarHoliday['label'], "{$year}-".$this->sonamLosarHoliday['dates'][$year]);
        }
        if (isset($this->gyalpoLosharHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->gyalpoLosharHoliday['label'], "{$year}-".$this->gyalpoLosharHoliday['dates'][$year]);
        }
        if (isset($this->udhauliParvaHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->udhauliParvaHoliday['label'], "{$year}-".$this->udhauliParvaHoliday['dates'][$year]);
        }
        if (isset($this->mahashivaratriHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->mahashivaratriHoliday['label'], "{$year}-".$this->mahashivaratriHoliday['dates'][$year]);
        }
        if (isset($this->holiHoliday['dates'][$year])) {
            $holidays[] = Holiday::religious($this->holiHoliday['label'], "{$year}-".$this->holiHoliday['dates'][$year]);
        }

        return $holidays;
    }

    /**
     * Holiday according to Gregorian calendar.
     *
     * @return array<Holiday>
     */
    public function holidayAccordingToGregorianCalendar(int $year): array
    {
        return [
            Holiday::national('International Labor Day', "{$year}-05-01"),
            Holiday::national('Christmas', "{$year}-12-25"),
        ];
    }
}
