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
        protected ?string $locale = null,
        protected ?CarbonImmutable $from = null,
        protected ?CarbonImmutable $to = null,
    ) {}

    public static function for(Country|string $country, ?int $year = null, ?string $locale = null): static
    {
        $year ??= CarbonImmutable::now()->year;

        if (is_string($country)) {
            $country = Country::findOrFail($country);
        }

        return new static($country, $year, $locale);
    }

    public static function has(string $country): bool
    {
        return Country::find($country) !== null;
    }

    /** @return array<array{name: string, date: CarbonImmutable}> */
    public function get(Country|string|null $country = null, ?int $year = null): array
    {
        $country ??= $this->country;
        $year ??= $this->year;

        return static::for($country, $year, $this->locale)
            ->calculate()
            ->toArray();
    }

    /**
     * getInRange method allows you to pick holidays in a range of dates,
     *   - dates are inclusive.
     *   - dates are swappable, lower date could be passed as second argument.
     *   - dates could be a CarbonInterface or a string.
     *   - acceptable strings formats are 'Y-m-d' or 'Y-m' or 'Y'
     *   - if passed string is 'Y-m' or 'Y' it will be converted to first(from) / last{to} day of the month(from) / year(to)
     * E.g. to retrieve all holidays in between
     *    - 2020-01-01 and 2024-12-31, you could use: getInRange('2020-01-01', '2024-12-31'), getInRange('2020-01', '2024-12') or getInRange('2020', '2024')
     *    - 2024-06-01 and 2025-05-30, you could use: getInRange('2024-06-01', '2025-05-30'), getInRange('2024-06', '2025-05')
     *
     * @return array<string, string> date => name
     */
    public function getInRange(CarbonInterface|string $from, CarbonInterface|string $to): array
    {
        if (! $from instanceof CarbonImmutable) {
            $from = match (strlen($from)) {
                4 => CarbonImmutable::parse($from.'-01-01'),
                7 => CarbonImmutable::parse($from.'-01'),
                default => CarbonImmutable::parse($from),
            };
        }

        if (! $to instanceof CarbonImmutable) {
            $to = match (strlen($to)) {
                4 => CarbonImmutable::parse($to.'-12-31'),
                7 => CarbonImmutable::parse($to)->endOfMonth(),
                default => CarbonImmutable::parse($to),
            };
        }

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        return $this->country->getInRange($from, $to);
    }

    public function isHoliday(CarbonInterface|string $date, Country|string|null $country = null): bool
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
            fn (string $holiday): string => CarbonImmutable::parse($holiday)->format('Y-m-d'),
            $holidays
        );

        return in_array($date->format('Y-m-d'), $formattedHolidays);
    }

    public function getName(CarbonInterface|string $date, Country|string|null $country = null): ?string
    {
        if (! $date instanceof CarbonImmutable) {
            $date = CarbonImmutable::parse($date);
        }

        $country ??= $this->country;

        $holidays = static::for($country, $date->year)
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
        $this->holidays = $this->country->get($this->year, $this->locale);

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
