<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Actions\Belgium;
use Spatie\Holidays\Exceptions\HolidaysException;

class Holidays
{
    /** @return array<string, string> */
    protected array $holidays = [];

    protected int $year;

    private function __construct(
        ?int $year = null,
        protected ?string $countryCode = 'BE' // @todo make this configurable ?
    ) {
        $this->year = $year ?? CarbonImmutable::now()->year;
    }

    public static function new(): static
    {
        return new static();
    }

    /** @return array{name: string, date: string} */
    public static function all(): array
    {
        return (new static())
            ->calculate()
            ->get();
    }

    public function year(int $year): static
    {
        return new static(year: $year);
    }

    public function country(string $countryCode): static
    {
        return new static(countryCode: $countryCode);
    }

    /** @return array{name: string, date: string} */
    public function get(): array
    {
        return $this->format($this->holidays);
    }

    protected function calculate(): self
    {
        $action = match ($this->countryCode) {
            'BE' => new Belgium(),
            null => throw HolidaysException::noCountryCode(),
            default => throw HolidaysException::unknownCountryCode($this->countryCode),
        };

        $this->holidays = $action->execute($this->year);

        return $this;
    }

    /**
     * @param array<string, string> $dates
     * @return array<array{name: string, date: string}>
     */
    protected function format(array $dates): array
    {
        $response = [];

        foreach ($dates as $name => $date) {
            $response[] = [
                'name' => $name,
                'date' => $date,
            ];
        }

        return $response;
    }
}
