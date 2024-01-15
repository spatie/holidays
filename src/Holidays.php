<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
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
    public static function all(): array
    {
        return (new static())
            ->calculate()
            ->get();
    }

    public function year(int $year): static
    {
        return new static(year: $year, country: $this->country);
    }

    public function country(string $countryCode): static
    {
        $this->country = Country::findOrFail($countryCode);

        return $this;
    }

    /** @return array<array{name: string, date: string}> */
    public function get(): array
    {
        if ($this->holidays === []) {
            $this->calculate();
        }

        return $this->format($this->holidays);
    }

    public function isHoliday(CarbonImmutable|string $date, string $countryCode): bool
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $this
            ->country($countryCode)
            ->year($date->year);

        $holidays = $this->get();

        if (in_array($date->format('d-m-Y'), array_column($holidays, 'date'), true)) {
            return true;
        }

        return false;
    }

    public function getName(CarbonImmutable|string $date, string $countryCode): ?string
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $this
            ->country($countryCode)
            ->year($date->year);

        $holidays = $this->get();

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

    /**
     * @param  array<string, CarbonImmutable>  $dates
     * @return array<array{name: string, date: string}>
     */
    protected function format(array $dates): array
    {
        $response = [];

        foreach ($dates as $name => $date) {
            $response[] = [
                'name' => $name,
                'date' => $date->format('d-m-Y'),
            ];
        }

        return $response;
    }
}
