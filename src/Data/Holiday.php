<?php

namespace Spatie\Holidays\Data;

class Holiday
{
    private function __construct(
        protected string $name,
        protected string $date,
    ) {
        // @todo ensure date is in Y-m-d format ?
    }

    public static function new(string $name, string $date): self
    {
        return new self(
            name: $name,
            date: $date,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
        ];
    }
}
