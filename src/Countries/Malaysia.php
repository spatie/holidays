<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use DateTime;
use IntlDateFormatter;
use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Exceptions\InvalidYear;

class Malaysia extends Country
{
    use ChineseCalendar;

    protected string $timezone = 'Asia/Kuala_Lumpur';

    /** @var array<int, string> $regions */
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

    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    public function countryCode(): string
    {
        return 'my';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
                'Hari Pekerja' => '05-01',
                'Hari Kebangsaan' => '08-31',
                'Hari Malaysia' => '09-16',
                'Hari Krismas' => '12-25',
            ], $this->variableHolidays($year), $this->regionHolidays($year));
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function variableHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone($this->timezone);

        $variableHolidays = [
            'Tahun Baru Cina' => $this->lunarNewYear($year),
            'Tahun Baru Cina Hari Kedua' => $this->lunarNewYear($year)->addDays(1),
            'Hari Raya Aidilfitri' => $this->hariAidilfitri($year),
            'Hari Raya Aidilfitri Hari Kedua' => $this->hariAidilfitri($year)->addDays(1),
            'Hari Wesak' => $this->hariWesak($year),
            'Hari Raya Aidiladha' => $this->hariAidiladha($year),
            'Awal Muharram' => $this->awalMuharram($year),
            'Maulidur Rasul' => $this->maulidurRasul($year),
        ];

        if ($this->hariKeputeraanYDP($year)) {
            $variableHolidays['Hari Keputeraan Yang Di-Pertuan Agong'] = $this->hariKeputeraanYDP($year);
        }

        return $variableHolidays;
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionHolidays(int $year): array
    {
        if ($this->region && !$this->validRegion($this->region)) {
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
     * @return array<string, CarbonImmutable|string>
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
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionJohor(int $year): array
    {
        $johorHolidays = [
            'Hari Keputeraan Sultan Johor' => CarbonImmutable::createFromDate($year, 3, 23, $this->timezone),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Awal Ramadan' => $this->awalRamadan($year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];

        $hariHolJohor = match ($year) {
            2020 => CarbonImmutable::createFromDate($year, 9, 24, $this->timezone),
            2021 => CarbonImmutable::createFromDate($year, 9, 13, $this->timezone),
            2022 => CarbonImmutable::createFromDate($year, 9, 3, $this->timezone),
            2023 => CarbonImmutable::createFromDate($year, 8, 23, $this->timezone),
            2024 => CarbonImmutable::createFromDate($year, 8, 11, $this->timezone),
            2025 => CarbonImmutable::createFromDate($year, 7, 31, $this->timezone),
            2026 => CarbonImmutable::createFromDate($year, 7, 21, $this->timezone),
            default => null,
        };
        
        if ($hariHolJohor) {
            $johorHolidays['Hari Hol Johor'] = $hariHolJohor;
        }

        return $johorHolidays;
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionKedah(int $year): array
    {
        return [
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Israk dan Mikraj' => $this->israkMikraj($year),
            'Awal Ramadan' => $this->awalRamadan($year),
            'Hari Keputeraan Sultan Kedah' => CarbonImmutable::parse("third sunday of june {$year}", $this->timezone),
            'Hari Raya Aidiladha Hari Kedua' => $this->hariAidiladha($year)->addDay(),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionKelantan(int $year): array
    {
        $kelantanHolidays = [
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Arafah' => $this->hariArafah($year),
            'Hari Raya Aidiladha Hari Kedua' => $this->hariAidiladha($year)->addDay(),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];

        $kingBirthday = match (true) {
            in_array($year, range(2010, 2022)) => CarbonImmutable::createFromDate($year, 11, 11, $this->timezone),
            in_array($year, range(2023, 2026)) => CarbonImmutable::createFromDate($year, 9, 29, $this->timezone),
            default => null,
    
        };

        if ($kingBirthday) {
            $kelantanHolidays['Hari Keputeraan Sultan Kelantan'] = $kingBirthday;
        }

        $kingBirthdaySecondDay = match (true) {
            in_array($year, range(2010, 2022)) => CarbonImmutable::createFromDate($year, 11, 12, $this->timezone),
            in_array($year, range(2023, 2026)) => CarbonImmutable::createFromDate($year, 9, 30, $this->timezone),
            default => null,
        };
        
        if ($kingBirthdaySecondDay) {
            $kelantanHolidays['Hari Keputeraan Sultan Kelantan Hari Kedua'] = $kingBirthdaySecondDay;
        }

        return $kelantanHolidays;
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionKualaLumpur(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Wilayah Persekutuan' => $this->hariWilayah($year),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionLabuan(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Wilayah Persekutuan' => $this->hariWilayah($year),
            'Pesta Kaamatan' => $this->pestaKaamatan($year),
            'Pesta Kaamatan Hari Kedua' => $this->pestaKaamatan($year)->addDay(),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionMelaka(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Awal Ramadan' => $this->awalRamadan($year),
            'Hari Perisytiharan Melaka Sebagai Bandaraya Bersejarah' => CarbonImmutable::createFromDate($year, 4, 15, $this->timezone),
            'Harijadi Yang di-Pertua Negeri Melaka' => CarbonImmutable::createFromDate($year, 8, 24, $this->timezone),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionNegeri9(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Israk dan Mikraj' => $this->israkMikraj($year),
            'Hari Keputeraan Yang Di-Pertuan Besar Negeri Sembilan' => CarbonImmutable::createFromDate($year, 1, 14, $this->timezone),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionPahang(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Hol Pahang' => CarbonImmutable::createFromDate($year, 5, 22, $this->timezone),
            'Hari Keputeraan Sultan Pahang' => CarbonImmutable::createFromDate($year, 7, 30, $this->timezone),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionPenang(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Bandar Warisan Dunia Georgetown' => CarbonImmutable::createFromDate($year, 7, 7, $this->timezone),
            'Harijadi Yang di-Pertua Negeri Pulau Pinang' => CarbonImmutable::parse("second saturday of july {$year}", $this->timezone),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionPerak(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Keputeraan Sultan Perak' => CarbonImmutable::parse("first friday of november {$year}", $this->timezone),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionPerlis(int $year): array
    {
        return [
            'Israk dan Mikraj' => $this->israkMikraj($year),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Keputeraan Raja Perlis' => CarbonImmutable::createFromDate($year, 5, 17, $this->timezone),
            'Hari Raya Aidiladha Hari Kedua' => $this->hariAidiladha($year)->addDays(1),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }
    
    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionPutrajaya(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Wilayah Persekutuan' => $this->hariWilayah($year),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionSabah(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Pesta Kaamatan' => $this->pestaKaamatan($year),
            'Pesta Kaamatan Hari Kedua' => $this->pestaKaamatan($year)->addDays(1),
            'Good Friday' => $this->goodFriday($year),
            'Harijadi Yang di-Pertua Negeri Sabah' => CarbonImmutable::parse("first saturday of october {$year}", $this->timezone),
            'Hari Deepavali' => $this->hariDeepavali($year),
            'Hari Natal' => CarbonImmutable::createFromDate($year, 12, 24, $this->timezone),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionSarawak(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Sarawak' => CarbonImmutable::createFromDate($year, 7, 22, $this->timezone),
            'Hari Gawai' => CarbonImmutable::createFromDate($year, 6, 1, $this->timezone),
            'Hari Gawai Kedua' => CarbonImmutable::createFromDate($year, 6, 2, $this->timezone),
            'Harijadi Yang di-Pertua Negeri Sarawak' => CarbonImmutable::parse("second saturday of october {$year}", $this->timezone),
            'Good Friday' => $this->goodFriday($year),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionSelangor(int $year): array
    {
        return [
            'Tahun Baru' => $this->newYear(),
            'Hari Thaipusam' => $this->hariThaipusam($year),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Deepavali' => $this->hariDeepavali($year),
            'Hari Keputeraan Sultan Selangor' => CarbonImmutable::createFromDate($year, 12, 11, $this->timezone),
        ];
    }

    /**
     * @return array<string, CarbonImmutable|string>
     */
    protected function regionTerengganu(int $year): array
    {
        return [
            'Israk dan Mikraj' => $this->israkMikraj($year),
            'Hari Ulang Tahun Pertabalan Sultan Terengganu' => CarbonImmutable::createFromDate($year, 3, 4, $this->timezone),
            'Hari Nurul Al-Quran' => $this->nuzulQuran($year),
            'Hari Keputeraan Sultan Terengganu' => CarbonImmutable::createFromDate($year, 4, 26, $this->timezone),
            'Hari Arafah' => $this->hariArafah($year),
            'Hari Raya Aidiladha Hari Kedua' => $this->hariAidiladha($year)->addDays(1),
            'Hari Deepavali' => $this->hariDeepavali($year),
        ];
    }

    private function newYear(): string
    {
        return '01-01';
    }

    private function lunarNewYear(int $year): CarbonImmutable
    {
        return $this->chineseToGregorianDate('01-01', $year);
    }

    protected function getIslamicFormatter(): IntlDateFormatter
    {
        return new IntlDateFormatter(
            locale: 'ms_MY@calendar=islamic-civil',
            dateType: IntlDateFormatter::MEDIUM,
            timeType: IntlDateFormatter::NONE,
            timezone: $this->timezone,
            calendar: IntlDateFormatter::TRADITIONAL
        );
    }

    protected function getHijriYear(int $year, bool $nextYear = false): int
    {
        $formatter = $this->getIslamicFormatter();
        $formatter->setPattern('yyyy');
        $dateTime = DateTime::createFromFormat('d/m/Y', '01/01/' . ($nextYear ? $year + 1 : $year));

        if (!$dateTime) {
            throw InvalidYear::invalidHijriYear();
        }

        return (int) $formatter->format($dateTime->getTimestamp());
    }

    /**
     * $input as in 'day-month'; 01-10 for syawal
     */
    protected function islamicCalendar(string $input, int $year, bool $nextYear = false): CarbonImmutable
    {
        $hijrYear = $this->getHijriYear(year: $year, nextYear: $nextYear);
        $formatter = $this->getIslamicFormatter();
        $timeStamp = (int) $formatter->parse($input . '/' . $hijrYear . ' AH');
        
        return CarbonImmutable::createFromTimestamp($timeStamp, $this->timezone);
    }

    protected function hariAidilfitri(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('01/10', $year);
    }

    protected function hariWilayah(int $year): CarbonImmutable
    {
        return CarbonImmutable::createFromDate($year, 2, 1, $this->timezone);
    }

    protected function israkMikraj(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('27/7', $year);
    }

    protected function awalRamadan(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('1/9', $year);
    }

    protected function pestaKaamatan(int $year): CarbonImmutable
    {
        return CarbonImmutable::createFromDate($year, 5, 30, $this->timezone);
    }

    protected function goodFriday(int $year): CarbonImmutable
    {
        $easter = $this->easter($year);
        
        return $easter->subDays(2);
    }

    protected function nuzulQuran(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('17/9', $year);
    }

    protected function hariKeputeraanYDP(int $year): ?CarbonImmutable
    {
        return match (true) {
            in_array($year, range(2001, 2026)) => CarbonImmutable::parse("first saturday of october {$year}", $this->timezone),
            default => null,
        };
    }

    protected function hariArafah(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('9/12', $year);
    }

    protected function hariAidiladha(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('10/12', $year);
    }

    protected function awalMuharram(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('1/1', $year, true);
    }

    protected function maulidurRasul(int $year): CarbonImmutable
    {
        return $this->islamicCalendar('12/3', $year, true);
    }

    protected function hariWesak(int $year): string
    {
        return '01-01';
    }

    protected function hariThaipusam(int $year): string
    {
        return '01-01';
    }

    protected function hariDeepavali(int $year): string
    {
        return '01-01';
    }
}
