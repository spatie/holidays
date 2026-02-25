<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use JsonSerializable;

readonly class Holiday implements JsonSerializable
{
    public function __construct(
        public string $name,
        public CarbonImmutable $date,
        public HolidayType $type = HolidayType::National,
        public ?string $region = null,
    ) {}

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
