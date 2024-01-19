<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use GeniusTS\HijriDate\Date;
use GeniusTS\HijriDate\Hijri;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Exceptions\UnsupportedCountry;

abstract class Country
{
    abstract public function countryCode(): string;

    /** @return array<string, string|CarbonImmutable> */
    abstract protected function allHolidays(int $year): array;

    /** @return array<string, CarbonImmutable|string> */
    public function get(int $year): array
    {
        $this->ensureYearCanBeCalculated($year);

        $allHolidays = $this->allHolidays($year);

        $allHolidays = array_map(function ($date) use ($year) {
            if (is_string($date)) {
                $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
            }

            return $date;
        }, $allHolidays);

        uasort($allHolidays,
            fn (CarbonImmutable $a, CarbonImmutable $b) => $a->timestamp <=> $b->timestamp
        );

        return $allHolidays;
    }

    public static function make(): static
    {
        return new static(...func_get_args());
    }

    protected function easter(int $year): CarbonImmutable
    {
        $easter = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-03-21")
            ->startOfDay();

        return $easter->addDays(easter_days($year));
    }

    public static function find(string $countryCode): ?Country
    {
        $countryCode = strtolower($countryCode);

        foreach (glob(__DIR__.'/../Countries/*.php') as $filename) {
            if (basename($filename) === 'Country.php') {
                continue;
            }

            // determine class name from file name
            $countryClass = '\\Spatie\\Holidays\\Countries\\'.basename($filename, '.php');

            /** @var Country $country */
            $country = new $countryClass;

            if (strtolower($country->countryCode()) === $countryCode) {
                return $country;
            }
        }

        return null;
    }

    public static function findOrFail(string $countryCode): Country
    {
        $country = self::find($countryCode);

        if (! $country) {
            throw UnsupportedCountry::make($countryCode);
        }

        return $country;
    }

    protected function ensureYearCanBeCalculated(int $year): void
    {
        /**
         * Most holidays have Easter as an anchor. Elsewhere in the
         * code we use PHP's native easter-date function, which can only handle
         * years between 1970 and 2037
         *
         * https://www.php.net/manual/en/function.easter-date.php
         */
        if ($year < 1970) {
            throw InvalidYear::yearTooLow();
        }

        if ($year > 2037) {
            throw InvalidYear::yearTooHigh();
        }
    }

    public static function eidAlFitr(int $year): CarbonImmutable {
        // get the Hirji date for the first day of the Gregorian year
        $hirji_date = Hijri::convertToHijri(CarbonImmutable::create($year));
        // Eid al-Fitr is on the first day of the 10th month in the calendar
        if ($hirji_date->month > 10) {
            // the date has passed to move to the next year
            $hirji_date->year($hirji_date->year + 1);
        }
        $eid_al_fitr = new Date(1, 10, $hirji_date->year);

        return CarbonImmutable::createFromTimestamp( Hijri::convertToGregorian($eid_al_fitr->day, $eid_al_fitr->month,
            $eid_al_fitr->year)->getTimestamp());
    }

    public static function eidAlAdha(int $year): CarbonImmutable {
        // get the Hirji date for the first day of the Gregorian year
        $hirji_date = Hijri::convertToHijri(CarbonImmutable::create($year));
        // Eid al-Fitr is on the first day of the 10th month in the calendar
        if ($hirji_date->month > 10) {
            // the date has passed to move to the next year
            $hirji_date->year($hirji_date->year + 1);
        }
        $eid_al_adha = new Date(10, 12, $hirji_date->year);

        return CarbonImmutable::createFromTimestamp( Hijri::convertToGregorian($eid_al_adha->day, $eid_al_adha->month,
            $eid_al_adha->year)->getTimestamp());
    }
}
