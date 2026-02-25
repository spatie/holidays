<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Malaysia extends Country
{
    use ChineseCalendar;
    use IslamicCalendar;

    protected string $timezone = 'Asia/Kuala_Lumpur';

    /** @var array<int, string> */
    protected array $regions = [
        'jhr',
        'kdh',
        'ktn',
        'kul',
        'lbn',
        'mlk',
        'nsn',
        'phg',
        'png',
        'prk',
        'pls',
        'pjy',
        'sbh',
        'swk',
        'sgr',
        'trg',
    ];

    /** @see https://www.timeanddate.com/holidays/malaysia/vesak-day */
    protected const hariWesak = [
        2020 => '05-07', 2021 => '05-26', 2022 => '05-15', 2023 => '05-04',
        2024 => '05-22', 2025 => '05-12', 2026 => '05-31',
    ];

    /** @see https://www.timeanddate.com/holidays/malaysia/thaipusam */
    protected const hariThaipusam = [
        2020 => '02-08', 2021 => '01-28', 2022 => '01-18', 2023 => '02-04',
        2024 => '01-25', 2025 => '02-11', 2026 => '02-01',
    ];

    /** @see https://www.timeanddate.com/holidays/malaysia/deepavali */
    protected const hariDeepavali = [
        2020 => '11-14', 2021 => '11-04', 2022 => '10-24', 2023 => '11-13',
        2024 => '11-01', 2025 => '10-20', 2026 => '11-08',
    ];

    protected function __construct(
        protected ?string $region = null,
    ) {}

    public function countryCode(): string
    {
        return 'my';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Hari Pekerja' => CarbonImmutable::createFromDate($year, 5, 1),
            'Hari Kebangsaan' => CarbonImmutable::createFromDate($year, 8, 31),
            'Hari Malaysia' => CarbonImmutable::createFromDate($year, 9, 16),
            'Hari Krismas' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year), $this->regionHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone($this->timezone);

        $variableHolidays = array_filter([
            'Tahun Baru Cina' => $this->chineseToGregorianDate('01-01', $year),
            'Tahun Baru Cina Hari Kedua' => $this->chineseToGregorianDate('01-02', $year),
            'Hari Raya Aidilfitri' => $this->islamicToGregorianDate('10-01', $year),
            'Hari Raya Aidilfitri Hari Kedua' => $this->islamicToGregorianDate('10-02', $year),
            'Hari Wesak' => $this->hariWesak($year),
            'Hari Raya Aidiladha' => $this->islamicToGregorianDate('12-10', $year),
            'Awal Muharram' => $this->islamicToGregorianDate('01-01', $year, true),
            'Maulidur Rasul' => $this->islamicToGregorianDate('03-12', $year, true),
        ]);

        if ($this->hariKeputeraanYDP($year)) {
            $variableHolidays['Hari Keputeraan Yang Di-Pertuan Agong'] = $this->hariKeputeraanYDP($year);
        }

        return $variableHolidays;
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionHolidays(int $year): array
    {
        if ($this->region && ! $this->validRegion($this->region)) {
            throw InvalidRegion::notFound($this->region);
        }

        return $this->holidaysByRegion($year);
    }

    protected function validRegion(string $region): bool
    {
        return in_array($region, $this->regions);
    }

    /**
     * return holiday by region, if not set return all
     *
     * @return array<string, CarbonImmutable>
     */
    protected function holidaysByRegion(int $year): array
    {
        return match ($this->region) {
            'jhr' => $this->regionJohor($year),
            'kdh' => $this->regionKedah($year),
            'ktn' => $this->regionKelantan($year),
            'kul' => $this->regionKualaLumpur($year),
            'lbn' => $this->regionLabuan($year),
            'mlk' => $this->regionMelaka($year),
            'nsn' => $this->regionNegeri9($year),
            'phg' => $this->regionPahang($year),
            'png' => $this->regionPenang($year),
            'prk' => $this->regionPerak($year),
            'pls' => $this->regionPerlis($year),
            'pjy' => $this->regionPutrajaya($year),
            'sbh' => $this->regionSabah($year),
            'swk' => $this->regionSarawak($year),
            'sgr' => $this->regionSelangor($year),
            'trg' => $this->regionTerengganu($year),
            default => array_merge(
                $this->regionJohor($year),
                $this->regionKedah($year),
                $this->regionKelantan($year),
                $this->regionKualaLumpur($year),
                $this->regionLabuan($year),
                $this->regionMelaka($year),
                $this->regionNegeri9($year),
                $this->regionPahang($year),
                $this->regionPenang($year),
                $this->regionPerak($year),
                $this->regionPerlis($year),
                $this->regionPutrajaya($year),
                $this->regionSabah($year),
                $this->regionSarawak($year),
                $this->regionSelangor($year),
                $this->regionTerengganu($year),
            ),
        };
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionJohor(int $year): array
    {
        $johorHolidays = array_filter([
            'Hari Keputeraan Sultan Johor' => CarbonImmutable::createFromDate($year, 3, 23),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Awal Ramadan' => $this->islamicToGregorianDate('09-01', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);

        $hariHolJohor = match ($year) {
            2020 => CarbonImmutable::createFromDate($year, 9, 24),
            2021 => CarbonImmutable::createFromDate($year, 9, 13),
            2022 => CarbonImmutable::createFromDate($year, 9, 3),
            2023 => CarbonImmutable::createFromDate($year, 8, 23),
            2024 => CarbonImmutable::createFromDate($year, 8, 11),
            2025 => CarbonImmutable::createFromDate($year, 7, 31),
            2026 => CarbonImmutable::createFromDate($year, 7, 21),
            default => null,
        };

        if ($hariHolJohor) {
            $johorHolidays['Hari Hol Johor'] = $hariHolJohor;
        }

        return $johorHolidays;
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionKedah(int $year): array
    {
        return array_filter([
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Israk dan Mikraj' => $this->islamicToGregorianDate('07-27', $year),
            'Awal Ramadan' => $this->islamicToGregorianDate('09-01', $year),
            'Hari Keputeraan Sultan Kedah' => CarbonImmutable::parse("third sunday of june {$year}"),
            'Hari Raya Aidiladha Hari Kedua' => $this->islamicToGregorianDate('12-11', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionKelantan(int $year): array
    {
        $kelantanHolidays = array_filter([
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Arafah' => $this->islamicToGregorianDate('12-09', $year),
            'Hari Raya Aidiladha Hari Kedua' => $this->islamicToGregorianDate('12-11', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);

        $kingBirthday = match (true) {
            in_array($year, range(2010, 2022)) => CarbonImmutable::createFromDate($year, 11, 11),
            in_array($year, range(2023, 2026)) => CarbonImmutable::createFromDate($year, 9, 29),
            default => null,

        };

        if ($kingBirthday) {
            $kelantanHolidays['Hari Keputeraan Sultan Kelantan'] = $kingBirthday;
        }

        $kingBirthdaySecondDay = match (true) {
            in_array($year, range(2010, 2022)) => CarbonImmutable::createFromDate($year, 11, 12),
            in_array($year, range(2023, 2026)) => CarbonImmutable::createFromDate($year, 9, 30),
            default => null,
        };

        if ($kingBirthdaySecondDay) {
            $kelantanHolidays['Hari Keputeraan Sultan Kelantan Hari Kedua'] = $kingBirthdaySecondDay;
        }

        return $kelantanHolidays;
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionKualaLumpur(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Wilayah Persekutuan' => $this->hariWilayah($year),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionLabuan(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Wilayah Persekutuan' => $this->hariWilayah($year),
            'Pesta Kaamatan' => $this->pestaKaamatan($year),
            'Pesta Kaamatan Hari Kedua' => $this->pestaKaamatan($year)->addDay(),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionMelaka(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Awal Ramadan' => $this->islamicToGregorianDate('09-01', $year),
            'Hari Perisytiharan Melaka Sebagai Bandaraya Bersejarah' => CarbonImmutable::createFromDate($year, 4, 15),
            'Harijadi Yang di-Pertua Negeri Melaka' => CarbonImmutable::createFromDate($year, 8, 24),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionNegeri9(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Israk dan Mikraj' => $this->islamicToGregorianDate('07-27', $year),
            'Hari Keputeraan Yang Di-Pertuan Besar Negeri Sembilan' => CarbonImmutable::createFromDate($year, 1, 14),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionPahang(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Hol Pahang' => CarbonImmutable::createFromDate($year, 5, 22),
            'Hari Keputeraan Sultan Pahang' => CarbonImmutable::createFromDate($year, 7, 30),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionPenang(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Bandar Warisan Dunia Georgetown' => CarbonImmutable::createFromDate($year, 7, 7),
            'Harijadi Yang di-Pertua Negeri Pulau Pinang' => CarbonImmutable::parse("second saturday of july {$year}"),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionPerak(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Keputeraan Sultan Perak' => CarbonImmutable::parse("first friday of november {$year}"),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionPerlis(int $year): array
    {
        return array_filter([
            'Israk dan Mikraj' => $this->islamicToGregorianDate('07-27', $year),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Keputeraan Raja Perlis' => CarbonImmutable::createFromDate($year, 5, 17),
            'Hari Raya Aidiladha Hari Kedua' => $this->islamicToGregorianDate('12-11', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionPutrajaya(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Wilayah Persekutuan' => $this->hariWilayah($year),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionSabah(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Pesta Kaamatan' => $this->pestaKaamatan($year),
            'Pesta Kaamatan Hari Kedua' => $this->pestaKaamatan($year)->addDays(1),
            'Good Friday' => $this->goodFriday($year),
            'Harijadi Yang di-Pertua Negeri Sabah' => CarbonImmutable::parse("first saturday of october {$year}"),
            'Hari Deepavali' => $this->hariDeepavali($year),
            'Hari Natal' => CarbonImmutable::createFromDate($year, 12, 24),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionSarawak(int $year): array
    {
        return [
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Sarawak' => CarbonImmutable::createFromDate($year, 7, 22),
            'Hari Gawai' => CarbonImmutable::createFromDate($year, 6, 1),
            'Hari Gawai Kedua' => CarbonImmutable::createFromDate($year, 6, 2),
            'Harijadi Yang di-Pertua Negeri Sarawak' => CarbonImmutable::parse("second saturday of october {$year}"),
            'Good Friday' => $this->goodFriday($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionSelangor(int $year): array
    {
        return array_filter([
            'Tahun Baru' => CarbonImmutable::createFromDate($year, 1, 1),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
            'Hari Keputeraan Sultan Selangor' => CarbonImmutable::createFromDate($year, 12, 11),
        ]);
    }

    /**
     * @return array<string, CarbonImmutable>
     */
    protected function regionTerengganu(int $year): array
    {
        return array_filter([
            'Israk dan Mikraj' => $this->islamicToGregorianDate('07-27', $year),
            'Hari Ulang Tahun Pertabalan Sultan Terengganu' => CarbonImmutable::createFromDate($year, 3, 4),
            'Hari Nurul Al-Quran' => $this->islamicToGregorianDate('09-17', $year),
            'Hari Keputeraan Sultan Terengganu' => CarbonImmutable::createFromDate($year, 4, 26),
            'Hari Arafah' => $this->islamicToGregorianDate('12-09', $year),
            'Hari Raya Aidiladha Hari Kedua' => $this->islamicToGregorianDate('12-11', $year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ]);
    }

    protected function hariWilayah(int $year): CarbonImmutable
    {
        return CarbonImmutable::createFromDate($year, 2, 1);
    }

    protected function pestaKaamatan(int $year): CarbonImmutable
    {
        return CarbonImmutable::createFromDate($year, 5, 30);
    }

    protected function goodFriday(int $year): CarbonImmutable
    {
        $easter = $this->easter($year);

        return $easter->subDays(2);
    }

    protected function hariKeputeraanYDP(int $year): ?CarbonImmutable
    {
        return match (true) {
            in_array($year, range(2001, 2026)) => CarbonImmutable::parse("first saturday of october {$year}"),
            default => null,
        };
    }

    protected function hariWesak(int $year): ?CarbonImmutable
    {
        $date = self::hariWesak[$year] ?? null;

        return $date ? CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay() : null;
    }

    protected function hariThaipusam(int $year): ?CarbonImmutable
    {
        $date = self::hariThaipusam[$year] ?? null;

        return $date ? CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay() : null;
    }

    protected function hariDeepavali(int $year): ?CarbonImmutable
    {
        $date = self::hariDeepavali[$year] ?? null;

        return $date ? CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}")?->startOfDay() : null;
    }
}
