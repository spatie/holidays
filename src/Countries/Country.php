<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Exceptions\UnsupportedCountry;

abstract class Country
{
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

    abstract public function countryCode(): string;

    /** @return array<string, CarbonImmutable> */
    abstract public function get(int $year): array;

    protected function ensureYearCanBeCalculated(int $year): void
    {
        // https://www.php.net/manual/en/function.easter-date.php
        if ($year < 1970) {
            throw InvalidYear::yearTooLow();
        }

        if ($year > 2037) {
            throw InvalidYear::yearTooHigh();
        }
    }
}
