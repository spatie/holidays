<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Actions\CalculateBelgianHolidaysAction;
use Spatie\Holidays\Data\Holiday;
use Spatie\Holidays\Exceptions\HolidaysException;

class Holidays
{
    /** @var array<Holiday> */
    protected array $holidays = [];

    private function __construct(
        protected ?int $year = null,
        protected ?string $countryCode = null
    ) {
        $this->year = $year ?? CarbonImmutable::now()->year;
    }

    public static function forYear(int $year): self
    {
        return new self(year: $year, countryCode: $this->countryCode);
    }

    public static function forCountry(string $countryCode): self
    {
        return new self(year: $this->year, countryCode: $countryCode);
    }

    public static function get(): array
    {
        return (new self())
            ->calculate()
            ->get();
    }

    /** @return array<Holiday> */
    public function get(): array
    {
        return $this->holidays;
    }

    protected function calculate(): self
    {
        $action = match ($this->countryCode) {
            'BE' => (new CalculateBelgianHolidaysAction()),
            null => throw HolidaysException::noCountryCode(),
            default => throw HolidaysException::unknownCountryCode($this->countryCode),
        };

        $this->holidays = $action->execute($this->year);

        return $this;
    }
}
