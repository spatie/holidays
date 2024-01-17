<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\States\State;

class Holidays
{
    /** @var array<string, CarbonImmutable> */
    protected array $holidays = [];

    protected function __construct(
        protected Country $country,
        protected int $year,
        protected ?State $state = null,
    ) {
    }

    public static function for(Country|string $country, State|string|null $state = null, ?int $year = null): static
    {
        $year ??= CarbonImmutable::now()->year;

        if (is_string($country)) {
            $country = Country::findOrFail($country);
        }

        if (is_string($state)) {
            $state = State::findOrFail($country, $state);
        }

        return new static($country, $year, $state);
    }

    public function inState(State|string $state): static
    {
        if (is_string($state)) {
            $state = State::findOrFail($this->country, $state);
        }

        $this->state = $state;

        return $this;
    }

    /** @return array<array{name: string, date: string}> */
    public function get(Country|string|null $country = null, State|string|null $state = null, ?int $year = null): array
    {
        $country ??= $this->country;
        $state ??= $this->state;
        $year ??= $this->year;

        return static::for($country, $state, $year)
            ->calculate()
            ->toArray();
    }

    public function isHoliday(CarbonInterface|string $date, Country|string|null $country = null, State|string|null $state = null): bool
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;
        $state ??= $this->state;

        $holidays = static::for($country, $state, $date->year)
            ->calculate()
            ->toArray();

        $holidays = array_column($holidays, 'date');

        $formattedHolidays = array_map(
            fn (string $holiday) => CarbonImmutable::parse($holiday)->format('Y-m-d'),
            $holidays
        );

        return in_array($date->format('Y-m-d'), $formattedHolidays);
    }

    public function getName(CarbonInterface|string $date, Country|string|null $country = null, State|string|null $state = null): ?string
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;
        $state ??= $this->state;

        $holidays = static::for($country, $state, $date->year)
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

    protected function calculate(): self
    {
        $this->holidays = $this->country->get($this->year, $this->state);

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
