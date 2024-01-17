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
        protected int $year,
    ) {}

    public static function for(Country|string $country, int $year = null): static
    {
        $year ??= CarbonImmutable::now()->year;

        if (is_string($country)) {
            $country = Country::findOrFail($country);
        }

        return new static($country, $year);
    }

    /** @return array<array{name: string, date: string}> */
    public function get(Country|string $country = null, ?int $year = null): array
    {
        $country ??= $this->country;
        $year ??= $this->year;

        return static::for($country, $year)
            ->calculate()
            ->toArray();
    }

    public function isHoliday(CarbonInterface|string $date, Country|string $country = null): bool
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;

        $holidays = static::for($country, $date->year)
            ->calculate()
            ->toArray();

        $holidays = array_column($holidays, 'date');

        $formattedHolidays = array_map(
            fn (string $holiday) => CarbonImmutable::parse($holiday)->format('d-m-Y'),
            $holidays
        );

        return in_array($date->format('d-m-Y'), $formattedHolidays);
    }

    public function getName(CarbonInterface|string $date, Country|string $country = null): ?string
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;

        $holidays = static::for($country, $date->year)
            ->calculate()
            ->toArray();

        $formattedDate = $date->format('d-m-Y');

        foreach($holidays as $holiday) {
            if (CarbonImmutable::parse($holiday['date'])->format('d-m-Y') == $formattedDate) {
                return $holiday['name'];
            }
        }

        return null;
    }

    protected function calculate(): self
    {
        $this->holidays = $this->country->get($this->year);

        uasort($this->holidays,
            fn (CarbonImmutable $a, CarbonImmutable $b) => $a->timestamp <=> $b->timestamp
        );

        return $this;
    }

    /** @return array<array{name: string, date: string}> */
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
