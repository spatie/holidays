<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Calendars\ChineseCalendar;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Indonesia extends Country implements HasTranslations
{
    use ChineseCalendar;
    use IslamicCalendar;
    use Translatable;

    protected string $timezone = 'Asia/Jakarta';

    public function defaultLocale(): string
    {
        return 'id';
    }

    public function countryCode(): string
    {
        return 'id';
    }

    // The official list of holidays in Indonesia is published by the government.
    // The list of holidays for 2025 is available at:
    // https://www.kemenkopmk.go.id/index.php/pemerintah-tetapkan-hari-libur-nasional-dan-cuti-bersama-tahun-2025
    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->nationalHolidays($year),
            $this->islamicHolidays($year),
            $this->christianHolidays($year),
            $this->chineseHolidays($year),
            $this->hinduHolidays($year),
            $this->buddhistHolidays($year),
        );
    }

    public function nationalHolidays(int $year): array
    {
        return [
            'Hari Proklamasi Kemerdekaan' => '08-17', // 17 Agustus
            'Hari Buruh Internasional' => '05-01', // 1 Mei
            'Hari Lahir Pancasila' => '06-01', // 1 Juni
        ];
    }

    public function islamicHolidays(int $year): array
    {
        $this->setIslamicCalendarTimezone($this->timezone);

        return [
            'Tahun Baru Islam' => $this->islamicToGregorianDate('1-1', $year, false), // 1 Muharram
            'Isra Mikraj Nabi Muhammad SAW' => $this->islamicToGregorianDate('07-27', $year, false), // 27 Rajab
            'Hari Raya Idul Adha' => $this->islamicToGregorianDate('12-10', $year, false), // 10 Dzulhijjah
            'Cuti Hari Raya Idul Adha' => $this->islamicToGregorianDate('12-10', $year, false)->addDay(), // 11 Dzulhijjah
            'Hari Raya Idul Fitri 1' => $this->islamicToGregorianDate('10-1', $year, false), // 1 Syawal
            'Hari Raya Idul Fitri 2' => $this->islamicToGregorianDate('10-1', $year, false)->addDay(), // 2 Syawal
            'Cuti Hari Raya Idul Fitri 1' => $this->islamicToGregorianDate('10-1', $year, false)->addDay(2), // 3 Syawal
            'Cuti Hari Raya Idul Fitri 2' => $this->islamicToGregorianDate('10-1', $year, false)->addDays(3), // 4 Syawal
            'Cuti Hari Raya Idul Fitri 3' => $this->islamicToGregorianDate('10-1', $year, false)->addDays(4), // 5 Syawal
            'Maulid Nabi Muhammad SAW' => $this->islamicToGregorianDate('3-12', $year, false), // 12 Rabi'ul Awal
        ];
    }

    public function christianHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Tahun Baru Masehi' => '01-01', // 1 Januari
            'Wafat Yesus Kristus' => $easter->subDays(2),
            'Hari Raya Paskah' => $easter,
            'Kenaikan Yesus Kristus' => $easter->addDays(39),
            'Cuti Kenaikan Yesus Kristus' => $easter->addDays(40),
            'Kelahiran Yesus Kristus' => '12-25', // 25 Desember
            'Cuti Kelahiran Yesus Kristus' => '12-26' // 26 Desember 2025
        ];
    }

    public function chineseHolidays(int $year): array
    {
        $this->setChineseCalendarTimezone($this->timezone);

        return [
            'Cuti Tahun Baru Imlek' => $this->chineseToGregorianDate('01-01', $year, false)->subDay(),
            'Tahun Baru Imlek' => $this->chineseToGregorianDate('01-01', $year, false),
        ];
    }

    public function hinduHolidays(int $year): array
    {
        return [
            // Cuti Hari Suci Nyepi
            // Hari Suci Nyepi
        ];
    }

    public function buddhistHolidays(int $year): array
    {
        return [
            // Hari Raya Waisak
            // Cuti Hari Raya Waisak
        ];
    }
}
