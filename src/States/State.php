<?php

namespace Spatie\Holidays\States;

use Carbon\CarbonImmutable;
use ReflectionClass;
use RuntimeException;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Exceptions\UnsupportedState;

abstract class State
{
    /**
     * @return class-string<Country>
     */
    abstract public static function country(): string;

    abstract public function stateCode(): string;

    /** @return array<string, string|CarbonImmutable> */
    abstract public function allHolidays(int $year): array;

    /** @return array<string, CarbonImmutable> */
    public function get(int $year): array
    {
        $this->ensureYearCanBeCalculated($year);

        $allHolidays = $this->allHolidays($year);

        $allHolidays = array_map(static function ($date) use ($year) {
            if (is_string($date)) {
                $date = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-{$date}");
            }

            if ($date === false) {
                throw new RuntimeException("Could not parse date for holidays.");
            }

            return $date;
        }, $allHolidays);

        uasort(
            $allHolidays,
            static fn (CarbonImmutable $a, CarbonImmutable $b) => $a->timestamp <=> $b->timestamp
        );

        return $allHolidays;
    }

    public static function make(?State $state = null): static
    {
        return new static($state);
    }

    public static function find(Country $country, string $stateCode): ?State
    {
        $stateCode = strtolower($stateCode);

        $countryName = (new ReflectionClass($country))->getShortName();

        $stateFiles = glob(__DIR__.'/../States/'.$countryName.'/*.php');

        if (!$stateFiles) {
            throw UnsupportedState::make($stateCode, $country->countryCode());
        }

        foreach ($stateFiles as $filename) {
            if (basename($filename) === 'State.php') {
                continue;
            }

            // determine class name from file name
            $stateClass = '\\Spatie\\Holidays\\States\\'.$countryName.'\\'.basename($filename, '.php');

            /** @var State $state */
            $state = new $stateClass;

            if (strtolower($state->stateCode()) === $stateCode) {
                return $state;
            }
        }

        return null;
    }

    public static function findOrFail(Country $country, string $stateCode): State
    {
        $state = self::find($country, $stateCode);

        if (! $state) {
            throw UnsupportedState::make($stateCode, $country->countryCode());
        }

        return $state;
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
