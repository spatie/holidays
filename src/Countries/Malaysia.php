<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

class Malaysia extends Country implements HasRegions
{
    use ChineseCalendar;
    use IslamicCalendar;

    protected string $timezone = 'Asia/Kuala_Lumpur';

    protected function eidAlFitrDates(): array
    {
        return [];
    }

    protected function eidAlAdhaDates(): array
    {
        return [];
    }

    protected const array REGIONS = [
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

    protected function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, static::regions())) {
            throw InvalidRegion::notFound($region);
        }
    }

    public static function regions(): array
    {
        return self::REGIONS;
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function countryCode(): string
    {
        return 'my';
    }

    /** @return array<Holiday> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Hari Pekerja', "{$year}-05-01"),
            Holiday::national('Hari Kebangsaan', "{$year}-08-31"),
            Holiday::national('Hari Malaysia', "{$year}-09-16"),
            Holiday::national('Hari Krismas', "{$year}-12-25"),
        ], $this->variableHolidays($year), $this->regionHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone($this->timezone);

        $holidays = [];

        $chineseNewYear1 = $this->chineseToGregorianDate('01-01', $year);
        $holidays[] = Holiday::national('Tahun Baru Cina', $chineseNewYear1);

        $chineseNewYear2 = $this->chineseToGregorianDate('01-02', $year);
        $holidays[] = Holiday::national('Tahun Baru Cina Hari Kedua', $chineseNewYear2);

        $rayaAidilfitri = $this->islamicToGregorianDate('10-01', $year);
        $holidays[] = Holiday::religious('Hari Raya Aidilfitri', $rayaAidilfitri);

        $rayaAidilfitri2 = $this->islamicToGregorianDate('10-02', $year);
        $holidays[] = Holiday::religious('Hari Raya Aidilfitri Hari Kedua', $rayaAidilfitri2);

        $hariWesak = $this->hariWesak($year);
        if ($hariWesak) {
            $holidays[] = Holiday::national('Hari Wesak', $hariWesak);
        }

        $rayaAidiladha = $this->islamicToGregorianDate('12-10', $year);
        $holidays[] = Holiday::religious('Hari Raya Aidiladha', $rayaAidiladha);

        $awalMuharram = $this->islamicToGregorianDate('01-01', $year, true);
        $holidays[] = Holiday::religious('Awal Muharram', $awalMuharram);

        $maulidurRasul = $this->islamicToGregorianDate('03-12', $year, true);
        $holidays[] = Holiday::religious('Maulidur Rasul', $maulidurRasul);

        $hariKeputeraanYDP = $this->hariKeputeraanYDP($year);
        if ($hariKeputeraanYDP) {
            $holidays[] = Holiday::national('Hari Keputeraan Yang Di-Pertuan Agong', $hariKeputeraanYDP);
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionHolidays(int $year): array
    {
        return $this->holidaysByRegion($year);
    }

    /** @return array<Holiday> */
    protected function holidaysByRegion(int $year): array
    {
        $holidays = match ($this->region) {
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

        return $this->uniqueHolidays($holidays);
    }

    /** @param array<Holiday> $holidays
     * @return array<Holiday> */
    private function uniqueHolidays(array $holidays): array
    {
        $seen = [];
        $unique = [];

        foreach ($holidays as $holiday) {
            $key = $holiday->name.'|'.$holiday->date->format('Y-m-d');
            if (! isset($seen[$key])) {
                $seen[$key] = true;
                $unique[] = $holiday;
            }
        }

        return $unique;
    }

    /** @return array<Holiday> */
    protected function regionJohor(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Hari Keputeraan Sultan Johor', "{$year}-03-23", 'jhr');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'jhr');
        }

        $awalRamadan = $this->islamicToGregorianDate('09-01', $year);
        $holidays[] = Holiday::regional('Awal Ramadan', $awalRamadan, 'jhr');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'jhr');
        }

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
            $holidays[] = Holiday::regional('Hari Hol Johor', $hariHolJohor, 'jhr');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionKedah(int $year): array
    {
        $holidays = [];

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'kdh');
        }

        $israkMikraj = $this->islamicToGregorianDate('07-27', $year);
        $holidays[] = Holiday::regional('Israk dan Mikraj', $israkMikraj, 'kdh');

        $awalRamadan = $this->islamicToGregorianDate('09-01', $year);
        $holidays[] = Holiday::regional('Awal Ramadan', $awalRamadan, 'kdh');

        $holidays[] = Holiday::regional('Hari Keputeraan Sultan Kedah', CarbonImmutable::parse("third sunday of june {$year}"), 'kdh');

        $rayaAidiladha2 = $this->islamicToGregorianDate('12-11', $year);
        $holidays[] = Holiday::regional('Hari Raya Aidiladha Hari Kedua', $rayaAidiladha2, 'kdh');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'kdh');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionKelantan(int $year): array
    {
        $holidays = [];

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'ktn');

        $hariArafah = $this->islamicToGregorianDate('12-09', $year);
        $holidays[] = Holiday::regional('Hari Arafah', $hariArafah, 'ktn');

        $rayaAidiladha2 = $this->islamicToGregorianDate('12-11', $year);
        $holidays[] = Holiday::regional('Hari Raya Aidiladha Hari Kedua', $rayaAidiladha2, 'ktn');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'ktn');
        }

        $kingBirthday = match (true) {
            in_array($year, range(2010, 2022)) => CarbonImmutable::createFromDate($year, 11, 11),
            in_array($year, range(2023, 2026)) => CarbonImmutable::createFromDate($year, 9, 29),
            default => null,

        };

        if ($kingBirthday) {
            $holidays[] = Holiday::regional('Hari Keputeraan Sultan Kelantan', $kingBirthday, 'ktn');
        }

        $kingBirthdaySecondDay = match (true) {
            in_array($year, range(2010, 2022)) => CarbonImmutable::createFromDate($year, 11, 12),
            in_array($year, range(2023, 2026)) => CarbonImmutable::createFromDate($year, 9, 30),
            default => null,
        };

        if ($kingBirthdaySecondDay) {
            $holidays[] = Holiday::regional('Hari Keputeraan Sultan Kelantan Hari Kedua', $kingBirthdaySecondDay, 'ktn');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionKualaLumpur(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'kul');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'kul');
        }

        $holidays[] = Holiday::regional('Hari Wilayah Persekutuan', $this->hariWilayah($year), 'kul');

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'kul');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'kul');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionLabuan(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'lbn');
        $holidays[] = Holiday::regional('Hari Wilayah Persekutuan', $this->hariWilayah($year), 'lbn');

        $pestaKaamatan = $this->pestaKaamatan($year);
        $holidays[] = Holiday::regional('Pesta Kaamatan', $pestaKaamatan, 'lbn');
        $holidays[] = Holiday::regional('Pesta Kaamatan Hari Kedua', $pestaKaamatan->addDay(), 'lbn');

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'lbn');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'lbn');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionMelaka(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'mlk');

        $awalRamadan = $this->islamicToGregorianDate('09-01', $year);
        $holidays[] = Holiday::regional('Awal Ramadan', $awalRamadan, 'mlk');

        $holidays[] = Holiday::regional('Hari Perisytiharan Melaka Sebagai Bandaraya Bersejarah', "{$year}-04-15", 'mlk');
        $holidays[] = Holiday::regional('Harijadi Yang di-Pertua Negeri Melaka', "{$year}-08-24", 'mlk');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'mlk');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionNegeri9(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'nsn');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'nsn');
        }

        $israkMikraj = $this->islamicToGregorianDate('07-27', $year);
        $holidays[] = Holiday::regional('Israk dan Mikraj', $israkMikraj, 'nsn');

        $holidays[] = Holiday::regional('Hari Keputeraan Yang Di-Pertuan Besar Negeri Sembilan', "{$year}-01-14", 'nsn');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'nsn');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionPahang(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'phg');

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'phg');

        $holidays[] = Holiday::regional('Hari Hol Pahang', "{$year}-05-22", 'phg');
        $holidays[] = Holiday::regional('Hari Keputeraan Sultan Pahang', "{$year}-07-30", 'phg');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'phg');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionPenang(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'png');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'png');
        }

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'png');

        $holidays[] = Holiday::regional('Hari Bandar Warisan Dunia Georgetown', "{$year}-07-07", 'png');
        $holidays[] = Holiday::regional('Harijadi Yang di-Pertua Negeri Pulau Pinang', CarbonImmutable::parse("second saturday of july {$year}"), 'png');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'png');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionPerak(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'prk');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'prk');
        }

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'prk');

        $holidays[] = Holiday::regional('Hari Keputeraan Sultan Perak', CarbonImmutable::parse("first friday of november {$year}"), 'prk');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'prk');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionPerlis(int $year): array
    {
        $holidays = [];

        $israkMikraj = $this->islamicToGregorianDate('07-27', $year);
        $holidays[] = Holiday::regional('Israk dan Mikraj', $israkMikraj, 'pls');

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'pls');

        $holidays[] = Holiday::regional('Hari Keputeraan Raja Perlis', "{$year}-05-17", 'pls');

        $rayaAidiladha2 = $this->islamicToGregorianDate('12-11', $year);
        $holidays[] = Holiday::regional('Hari Raya Aidiladha Hari Kedua', $rayaAidiladha2, 'pls');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'pls');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionPutrajaya(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'pjy');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'pjy');
        }

        $holidays[] = Holiday::regional('Hari Wilayah Persekutuan', $this->hariWilayah($year), 'pjy');

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'pjy');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'pjy');
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionSabah(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'sbh');

        $pestaKaamatan = $this->pestaKaamatan($year);
        $holidays[] = Holiday::regional('Pesta Kaamatan', $pestaKaamatan, 'sbh');
        $holidays[] = Holiday::regional('Pesta Kaamatan Hari Kedua', $pestaKaamatan->addDays(1), 'sbh');

        $goodFriday = $this->goodFriday($year);
        $holidays[] = Holiday::regional('Good Friday', $goodFriday, 'sbh');

        $holidays[] = Holiday::regional('Harijadi Yang di-Pertua Negeri Sabah', CarbonImmutable::parse("first saturday of october {$year}"), 'sbh');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'sbh');
        }

        $holidays[] = Holiday::regional('Hari Natal', "{$year}-12-24", 'sbh');

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionSarawak(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'swk');
        $holidays[] = Holiday::regional('Hari Sarawak', "{$year}-07-22", 'swk');
        $holidays[] = Holiday::regional('Hari Gawai', "{$year}-06-01", 'swk');
        $holidays[] = Holiday::regional('Hari Gawai Kedua', "{$year}-06-02", 'swk');
        $holidays[] = Holiday::regional('Harijadi Yang di-Pertua Negeri Sarawak', CarbonImmutable::parse("second saturday of october {$year}"), 'swk');

        $goodFriday = $this->goodFriday($year);
        $holidays[] = Holiday::regional('Good Friday', $goodFriday, 'swk');

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionSelangor(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::regional('Tahun Baru', "{$year}-01-01", 'sgr');

        $hariThaipusam = $this->hariThaipusam($year);
        if ($hariThaipusam) {
            $holidays[] = Holiday::regional('Hari Thaipusam', $hariThaipusam, 'sgr');
        }

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'sgr');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'sgr');
        }

        $holidays[] = Holiday::regional('Hari Keputeraan Sultan Selangor', "{$year}-12-11", 'sgr');

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionTerengganu(int $year): array
    {
        $holidays = [];

        $israkMikraj = $this->islamicToGregorianDate('07-27', $year);
        $holidays[] = Holiday::regional('Israk dan Mikraj', $israkMikraj, 'trg');

        $holidays[] = Holiday::regional('Hari Ulang Tahun Pertabalan Sultan Terengganu', "{$year}-03-04", 'trg');

        $nurulAlQuran = $this->islamicToGregorianDate('09-17', $year);
        $holidays[] = Holiday::regional('Hari Nurul Al-Quran', $nurulAlQuran, 'trg');

        $holidays[] = Holiday::regional('Hari Keputeraan Sultan Terengganu', "{$year}-04-26", 'trg');

        $hariArafah = $this->islamicToGregorianDate('12-09', $year);
        $holidays[] = Holiday::regional('Hari Arafah', $hariArafah, 'trg');

        $rayaAidiladha2 = $this->islamicToGregorianDate('12-11', $year);
        $holidays[] = Holiday::regional('Hari Raya Aidiladha Hari Kedua', $rayaAidiladha2, 'trg');

        $hariDeepavali = $this->hariDeepavali($year);
        if ($hariDeepavali) {
            $holidays[] = Holiday::regional('Hari Deepavali', $hariDeepavali, 'trg');
        }

        return $holidays;
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
