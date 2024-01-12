<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Exceptions\InvalidYear;

abstract class Country
{
    public static function find(string $countryCode): ?Country
    {
        $countryCode = strtolower($countryCode);

        foreach (glob(__DIR__ . '/../Countries/*.php') as $filename) {
            if (basename($filename) === 'Country.php') {
                continue;
            }

            // determine class name from file name
            $countryClass = "\\Spatie\\Holidays\\Countries\\" .  basename($filename, '.php');

            /** @var \Spatie\Holidays\Countries\Country $country */
            $country = new $countryClass;


            if (strtolower($country->countryCode()) === $countryCode) {
                return $country;
            }
        }

        return null;
    }

    abstract function countryCode(): string;

    abstract public function get(int $year): array;

    protected static function ensureYearCanBeCalculated(int $year): void
    {
        if ($year < 1970) {
            throw InvalidYear::yearTooLow();
        }

        if ($year > 2037) {
            throw InvalidYear::yearTooHigh();
        }
    }
}
