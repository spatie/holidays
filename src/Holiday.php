<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use JsonSerializable;

readonly class Holiday implements JsonSerializable
{
    protected function __construct(
        public string $name,
        public CarbonImmutable $date,
        public HolidayType $type = HolidayType::National,
        public ?string $region = null,
    ) {}

    public static function make(
        string $name,
        CarbonImmutable $date,
        HolidayType $type,
        ?string $region = null,
    ): static {
        return new static($name, $date, $type, $region);
    }

    public static function national(string $name, CarbonImmutable|string $date): self
    {
        return static::make($name, self::parseDate($date), HolidayType::National);
    }

    public static function religious(string $name, CarbonImmutable|string $date): self
    {
        return static::make($name, self::parseDate($date), HolidayType::Religious);
    }

    public static function observed(string $name, CarbonImmutable|string $date): self
    {
        return static::make($name, self::parseDate($date), HolidayType::Observed);
    }

    public static function regional(string $name, CarbonImmutable|string $date, ?string $region = null): self
    {
        return static::make($name, self::parseDate($date), HolidayType::Regional, $region);
    }

    public static function bank(string $name, CarbonImmutable|string $date): self
    {
        return static::make($name, self::parseDate($date), HolidayType::Bank);
    }

    private static function parseDate(CarbonImmutable|string $date): CarbonImmutable
    {
        if ($date instanceof CarbonImmutable) {
            return $date;
        }

        return CarbonImmutable::parse($date);
    }

    /** @return array{name: string, date: string, type: string, region: string|null} */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date->toDateString(),
            'type' => $this->type->value,
            'region' => $this->region,
        ];
    }
}
