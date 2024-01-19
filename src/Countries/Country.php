<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
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

    /** @return array<string, string>  date => name */
    public function getInRange(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $this->ensureYearCanBeCalculated($from->year);
        $this->ensureYearCanBeCalculated($to->year);

        $allHolidays = [];

        for ($year = $from->year; $year <= $to->year; $year++) {
            $yearHolidays = $this->get($year);

            uasort($yearHolidays,
                static fn (CarbonImmutable $a, CarbonImmutable $b) => $a->timestamp <=> $b->timestamp
            );

            $flippedArray = array_column(
                                array_map(static function (CarbonImmutable $date, string $name) {
                                    return [$date->format('Y-m-d'), $name];
                                },
                                array_values($yearHolidays),
                                array_keys($yearHolidays))
                            , 1 ,0);

            if ($year === $from->year || $year === $to->year) {
            $flippedArray = array_filter($flippedArray, static function (string $date) use ($from, $to) {
                $date = CarbonImmutable::parse($date);

                return $date->between($from, $to);
            }, ARRAY_FILTER_USE_KEY);
            }

            $allHolidays = array_merge($allHolidays, $flippedArray);
        }
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
}
