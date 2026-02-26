<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\CountryRegistry;
use Spatie\Holidays\Exceptions\InvalidCountry;
use Spatie\Holidays\Exceptions\InvalidYear;
use Spatie\Holidays\Holiday;
use Spatie\Holidays\HolidayType;

abstract class Country
{
    abstract public function countryCode(): string;

    /** @return array<Holiday> */
    abstract protected function allHolidays(int $year): array;

    /** @return array<Holiday> */
    public function get(int $year, ?string $locale = null): array
    {
        $this->ensureYearCanBeCalculated($year);

        $holidays = $this->allHolidays($year);

        $translations = $this->loadTranslations($locale);

        if ($translations !== null) {
            $holidays = array_map(
                static fn (Holiday $holiday): Holiday => new Holiday(
                    $translations[$holiday->name] ?? $holiday->name,
                    $holiday->date,
                    $holiday->type,
                    $holiday->region,
                ),
                $holidays,
            );
        }

        usort($holidays, static fn (Holiday $a, Holiday $b): int => $a->date->timestamp <=> $b->date->timestamp);

        return $holidays;
    }

    protected function defaultLocale(): ?string
    {
        return null;
    }

    /** @return array<string, string>|null */
    private function loadTranslations(?string $locale): ?array
    {
        $locale ??= $this->defaultLocale();

        if ($locale === null) {
            return null;
        }

        $filePath = __DIR__."/../../lang/{$this->countryCode()}/{$locale}/holidays.json";

        if (! file_exists($filePath)) {
            return null;
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            return null;
        }

        /** @var array<string, string> */
        return json_decode($content, true);
    }

    /** @return array<Holiday> */
    public function getInRange(?CarbonImmutable $from, ?CarbonImmutable $to, ?string $locale = null): array
    {
        $from ??= CarbonImmutable::now()->startOfYear();
        $to ??= CarbonImmutable::now()->endOfYear();

        $this->ensureYearCanBeCalculated($from->year);
        $this->ensureYearCanBeCalculated($to->year);

        $allHolidays = [];

        for ($year = $from->year; $year <= $to->year; $year++) {
            foreach ($this->get($year, $locale) as $holiday) {
                if ($holiday->date->between($from, $to)) {
                    $allHolidays[] = $holiday;
                }
            }
        }

        usort($allHolidays, static fn (Holiday $a, Holiday $b): int => $a->date->timestamp <=> $b->date->timestamp);

        return $allHolidays;
    }

    public static function make(): static
    {
        return new static(...func_get_args());
    }

    protected function easter(int $year): CarbonImmutable
    {
        $easter = $this->createDate('Y-m-d', "{$year}-03-21");

        return $easter->addDays(easter_days($year));
    }

    protected function orthodoxEaster(int $year): CarbonImmutable
    {
        // Paschal full moon date
        // Not covered edge case:
        // when the full moon is on a 3 April, Easter is the next Sunday
        $easter = $this->createDate('Y-m-d', "{$year}-04-03");

        return $easter->addDays(easter_days($year, CAL_EASTER_ALWAYS_JULIAN));
    }

    public static function find(string $countryCode, ?string $region = null): ?Country
    {
        $class = CountryRegistry::find($countryCode);

        if ($class === null) {
            return null;
        }

        if ($region !== null && is_a($class, HasRegions::class, true)) {
            return new $class($region);
        }

        return new $class;
    }

    public static function findOrFail(string $countryCode, ?string $region = null): Country
    {
        $country = self::find($countryCode, $region);

        if (! $country) {
            throw InvalidCountry::notFound($countryCode);
        }

        return $country;
    }

    /** @return array{int, int}|null */
    protected function supportedYearRange(): ?array
    {
        return null;
    }

    protected function ensureYearCanBeCalculated(int $year): void
    {
        $range = $this->supportedYearRange();

        if ($range === null) {
            return;
        }

        [$min, $max] = $range;

        if ($year < $min || $year > $max) {
            throw InvalidYear::range($this->countryCode(), $min, $max);
        }
    }

    /**
     * Convert holidays that are represented as CarbonPeriods to an array of Holiday objects.
     * This is useful for holidays like `Eid-al-Fitr` that happen on multiple days.
     *
     * @return array<Holiday>
     */
    protected function convertPeriods(
        string $name,
        int $year,
        CarbonPeriod $period,
        HolidayType $type = HolidayType::National,
        string $suffix = 'Day',
        string $prefix = '',
        bool $includeEve = false,
    ): array {
        $allDays = [];

        if ($includeEve) {
            $eve = $period->first()?->subDay();

            if ($eve && $eve->year === $year) {
                $allDays[] = new Holiday("{$name} Eve", $eve->toImmutable(), $type);
            }
        }

        /** @var CarbonInterface $day */
        // @phpstan-ignore-next-line
        foreach ($period as $index => $day) {
            if ($day->year !== $year) {
                continue; // Lunar based holidays can overlap in 2 years
            }

            /** @var int $indexInt */
            $indexInt = $index;
            $formattedSuffix = $indexInt > 0
                ? " {$suffix} ".($indexInt + 1)
                : '';

            $holidayName = "{$prefix}{$name}{$formattedSuffix}";

            $allDays[] = new Holiday($holidayName, $day->toImmutable(), $type);
        }

        return $allDays;
    }

    protected function createDate(string $format, string $date): CarbonImmutable
    {
        $result = CarbonImmutable::createFromFormat($format, $date);

        if ($result === null) {
            throw new \RuntimeException("Invalid date format: {$date}");
        }

        return $result;
    }
}
