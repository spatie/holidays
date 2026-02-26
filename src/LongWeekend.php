<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use JsonSerializable;

readonly class LongWeekend implements JsonSerializable
{
    /**
     * @param  array<Holiday>  $holidays
     */
    public function __construct(
        public CarbonImmutable $startDate,
        public CarbonImmutable $endDate,
        public int $dayCount,
        public array $holidays,
    ) {}

    /** @return array{startDate: string, endDate: string, dayCount: int, holidays: array<Holiday>} */
    public function jsonSerialize(): array
    {
        return [
            'startDate' => $this->startDate->toDateString(),
            'endDate' => $this->endDate->toDateString(),
            'dayCount' => $this->dayCount,
            'holidays' => $this->holidays,
        ];
    }
}
