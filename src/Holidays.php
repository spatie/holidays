<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Countries\Country;

class Holidays
{
    /** @var array<string, CarbonImmutable> */
    protected array $holidays = [];

    protected function __construct(
        protected Country $country,
        protected int     $year,
        protected ?string $region = null,
    )
    {
    }

    public static function for(Country|string $country, ?string $region = null, ?int $year = null): static
    {
        $year ??= CarbonImmutable::now()->year;

        if (is_string($country)) {
            $country = Country::findOrFail($country);
        }

        return new static($country, year: $year, region: $region);
    }

    /** @return array<array{name: string, date: string}> */
    public function get(Country|string|null $country = null, ?int $year = null, ?string $region = null): array
    {
        $country ??= $this->country;
        $year ??= $this->year;
        $region ??= $this->region;

        return static::for($country, region: $region, year: $year)
            ->calculate()
            ->toArray();
    }

    public function isHoliday(CarbonInterface|string $date, Country|string|null $country = null, ?string $region = null): bool
    {
        if (!$date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;
        $region ??= $this->region;

        $holidays = static::for($country, $date->year, $region)
            ->calculate($region)
            ->toArray();

        $holidays = array_column($holidays, 'date');

        $formattedHolidays = array_map(
            fn(string $holiday) => CarbonImmutable::parse($holiday)->format('Y-m-d'),
            $holidays
        );

        return in_array($date->format('Y-m-d'), $formattedHolidays);
    }

    public function getName(CarbonInterface|string $date, Country|string|null $country = null, ?string $region = null): ?string
    {
        if (!$date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;
        $region ??= $this->region;
        $holidays = static::for($country, region: $region, year: $date->year)
            ->calculate()
            ->toArray();

        $formattedDate = $date->format('Y-m-d');

        foreach ($holidays as $holiday) {
            if (CarbonImmutable::parse($holiday['date'])->format('Y-m-d') == $formattedDate) {
                return $holiday['name'];
            }
        }

        return null;
    }

    protected function calculate(?string $region = null): self
    {
        $region ??= $this->region;
        $this->holidays = $this->country->get($this->year, $region);
        return $this;
    }

    /** @return array<array{name: string, date: CarbonImmutable}> */
    protected function toArray(): array
    {
        $response = [];

        foreach ($this->holidays as $name => $date) {
            $response[] = [
                'name' => $name,
                'date' => $date,
            ];
        }

        return $response;
    }
}
