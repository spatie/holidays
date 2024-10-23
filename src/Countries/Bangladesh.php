<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Calendars\BangladeshiCalander;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Bangladesh extends Country implements HasTranslations
{
    use Translatable;
    use BangladeshiCalander;

    protected string $timezone = 'Asia/Dhaka';

    /**
     * Islamic month numbers for reference
     */
    private const ISLAMIC_MONTHS = [
        'MUHARRAM' => '01',
        'SAFAR' => '02',
        'RABI_AL_AWWAL' => '03',
        'RABI_AL_THANI' => '04',
        'JUMADA_AL_AWWAL' => '05',
        'JUMADA_AL_THANI' => '06',
        'RAJAB' => '07',
        'SHABAN' => '08',
        'RAMADAN' => '09',
        'SHAWWAL' => '10',
        'DHU_AL_QADAH' => '11',
        'DHU_AL_HIJJAH' => '12',
    ];

    /**
     * Bengali calendar months
     */
    private const BENGALI_MONTHS = [
        'BOISHAKH' => 1,    // বৈশাখ
        'JYOISHTHO' => 2,   // জ্যৈষ্ঠ
        'ASHAR' => 3,       // আষাঢ়
        'SHRABON' => 4,     // শ্রাবণ
        'BHADRO' => 5,      // ভাদ্র
        'ASHWIN' => 6,      // আশ্বিন
        'KARTIK' => 7,      // কার্তিক
        'OGROHAYON' => 8,   // অগ্রহায়ণ
        'POUSH' => 9,       // পৌষ
        'MAGH' => 10,       // মাঘ
        'FALGUN' => 11,     // ফাল্গুন
        'CHOITRO' => 12,    // চৈত্র
    ];

    /**
     * Fixed national holidays
     */
    private const NATIONAL_HOLIDAYS = [
        'International Mother Language Day' => '02-21', // শহীদ দিবস
        'Independence Day' => '03-26',                  // স্বাধীনতা দিবস
        'May Day' => '05-01',                          // মে দিবস
        'National Mourning Day' => '08-15',            // জাতীয় শোক দিবস
        'Victory Day' => '12-16',                      // বিজয় দিবস
        'Christmas Day' => '12-25',                    // বড়দিন
    ];

    public function countryCode(): string
    {
        return 'bd';
    }

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            self::NATIONAL_HOLIDAYS,
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        return array_merge(
            $this->getIslamicHolidays($year),
            $this->getBengaliHolidays($year),
            $this->getHinduBuddhistHolidays($year)
        );
    }

    /**
        * Get all Islamic holidays for the year
        *
        * @return array<string, CarbonImmutable>
        */
    private function getIslamicHolidays(int $year): array
    {
        return array_merge(
            $this->convertPeriods('Shab-e-Barat', $year, $this->shabEBarat($year)[0]),
            $this->convertPeriods('Shab-e-Qadr', $year, $this->shabEQadr($year)[0]),
            $this->convertPeriods('Eid ul-Fitr', $year, $this->eidUlFitr($year)[0], includeEve: true),
            $this->convertPeriods('Eid ul-Adha', $year, $this->eidUlAdha($year)[0], includeEve: true),
            $this->convertPeriods('Eid-e-Miladunnabi', $year, $this->eideMiladunnabi($year)[0]),
            $this->convertPeriods('Ashura', $year, $this->ashura($year)[0]),
            $this->convertPeriods('Shab-e-Meraj', $year, $this->shabEMeraj($year)[0])
        );
    }

    /**
     * Get all Bengali calendar holidays for the year
     *
     * @return array<string, CarbonImmutable>
     */
    private function getBengaliHolidays(int $year): array
    {
        return array_merge(
            $this->convertPeriods('Pohela Boishakh', $year, $this->pohela_boishakh($year)[0])
        );
    }

    /**
     * Get all Hindu and Buddhist holidays for the year
     *
     * @return array<string, CarbonImmutable>
     */
    private function getHinduBuddhistHolidays(int $year): array
    {
        return array_merge(
            $this->convertPeriods('Buddha Purnima', $year, $this->buddhaPurnima($year)[0]),
            $this->convertPeriods('Jonmashtomi', $year, $this->jonmashtomi($year)[0]),
            $this->convertPeriods('Durga Puja', $year, $this->durgaPuja($year)[0])
        );
    }
}
