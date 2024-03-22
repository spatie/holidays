<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Carbon\Exceptions\InvalidFormatException;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Exceptions\InvalidCountry;
use Spatie\Holidays\Exceptions\InvalidYear;

abstract class Country
{
    abstract public function countryCode(): string;

    /** @return array<string, string|CarbonImmutable> */
    abstract protected function allHolidays(int $year): array;

    /** @return array<string, CarbonImmutable> */
    public function get(int $year, ?string $locale = null): array
    {
        $this->ensureYearCanBeCalculated($year);

        $allHolidays = $this->allHolidays($year);

        $translatedHolidays = [];
        foreach ($allHolidays as $name => $date) {
            if (is_string($date)) {
                if (strlen($date) > 5) {
                    $date = (new CarbonImmutable($date.' '.$year))->startOfDay();
                } else {
                    $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
                }
            }

            if ($date === null) {
                throw new InvalidFormatException("Invalid date for holiday `{$name}`");
            }

            if ($this instanceof HasTranslations) {
                $name = $this->translate(basename(str_replace('\\', '/', static::class)), $name, $locale);
            }

            $translatedHolidays[$name] = $date;
        }

        uasort($translatedHolidays,
            fn (CarbonImmutable $a, CarbonImmutable $b) => $a->timestamp <=> $b->timestamp
        );

        return $translatedHolidays;
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

    protected function orthodoxEaster(int $year): CarbonImmutable
    {
        // Paschal full moon date
        // Not covered edge case:
        // when the full moon is on a 3 April, Easter is the next Sunday
        $easter = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-04-03")
            ->startOfDay();

        return $easter->addDays(easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
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
            throw InvalidCountry::notFound($countryCode);
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
            throw InvalidYear::yearTooLow(1970);
        }

        if ($year > 2037) {
            throw InvalidYear::yearTooHigh(2038);
        }
    }

    /**
     * Convert holidays that are represented as CarbonPeriods to an array of CarbonImmutable dates.
     * This is useful for holidays like `Eid-al-Fitr` that happen on multiple days.
     *
     * @return array<string, CarbonImmutable>
     */
    protected function convertPeriods(
        string $name,
        int $year,
        CarbonPeriod $period,
        string $suffix = 'Day',
        string $prefix = '',
        bool $includeEve = false,
    ): array {
        $allDays = [];

        if ($includeEve) {
            $eve = $period->first()?->subDay();

            if ($eve && $eve->year === $year) {
                $allDays[$name.' Eve'] = $eve->toImmutable();
            }
        }

        /** @var CarbonInterface $day */
        foreach ($period as $index => $day) {
            if ($day->year !== $year) {
                continue; // Lunar based holidays can overlap in 2 years
            }

            if ($index > 0) {
                $formattedSuffix = " {$suffix} ".$index + 1;
            } else {
                $formattedSuffix = '';
            }

            $holidayName = "{$prefix}{$name}{$formattedSuffix}";

            $allDays[$holidayName] = $day->toImmutable();
        }

        return $allDays;
    }
}
