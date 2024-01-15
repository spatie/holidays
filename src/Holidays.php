<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Countries\Country;

class Holidays
{
    /** @var array<string, CarbonImmutable> */
    protected array $holidays = [];

    protected int $year;

    protected Country $country;

    private function __construct(
        ?int $year = null,
        ?Country $country = null,
    ) {
        $this->year = $year ?? CarbonImmutable::now()->year;
        $this->country = $country ?? Country::findOrFail('be');
    }

    public static function new(): static
    {
        return new static();
    }

    /** @return array<array{name: string, date: string}> */
    public static function get(?string $country = null, ?int $year = null): array
    {
        $country = is_string($country) ? Country::findOrFail($country) : null;

        return (new static(year: $year, country: $country))
            ->calculate()
            ->toArray();
    }

    public function isHoliday(CarbonInterface|string $date, string $countryCode): bool
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $holidays = $this
            ->setCountry($countryCode)
            ->setYear($date->year)
            ->calculate()
            ->toArray();

        if (in_array($date->format('d-m-Y'), array_column($holidays, 'date'), true)) {
            return true;
        }

        return false;
    }

    public function getName(CarbonInterface|string $date, string $countryCode): ?string
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $holidays = $this
            ->setCountry($countryCode)
            ->setYear($date->year)
            ->calculate()
            ->toArray();

        if (in_array($date->format('d-m-Y'), array_column($holidays, 'date'), true)) {
            return $holidays[array_search($date->format('d-m-Y'), array_column($holidays, 'date'), true)]['name'];
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

    protected function setYear(int $year): static
    {
        return new static(year: $year, country: $this->country);
    }

    protected function setCountry(string $countryCode): static
    {
        return new static (year: $this->year, country: Country::findOrFail($countryCode));
    }

    /** @return array<array{name: string, date: string}> */
    protected function toArray(): array
    {
        $response = [];

        foreach ($this->holidays as $name => $date) {
            $response[] = [
                'name' => $name,
                'date' => $date->format('d-m-Y'),
            ];
        }

        return $response;
    }
}
