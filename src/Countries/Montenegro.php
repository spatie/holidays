<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Montenegro extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'me';
    }

    public function defaultLocale(): string
    {
        return 'sr';
    }

    protected function allHolidays(int $year): array
    {
        // Montenegro has two days off for most holidays
        return array_merge([
            'Nova godina - prvi dan' => CarbonImmutable::createFromDate($year, 1, 1),
            'Nova godina - drugi dan' => CarbonImmutable::createFromDate($year, 1, 2),
            'Badnji dan' => CarbonImmutable::createFromDate($year, 1, 6),
            'Božić - prvi dan' => CarbonImmutable::createFromDate($year, 1, 7),
            'Božić - drugi dan' => CarbonImmutable::createFromDate($year, 1, 8),
            'Praznik rada - prvi dan' => CarbonImmutable::createFromDate($year, 5, 1),
            'Praznik rada - drugi dan' => CarbonImmutable::createFromDate($year, 5, 2),
            'Dan nezavisnosti - prvi dan' => CarbonImmutable::createFromDate($year, 5, 21),
            'Dan nezavisnosti - drugi dan' => CarbonImmutable::createFromDate($year, 5, 22),
            'Dan državnosti - prvi dan' => CarbonImmutable::createFromDate($year, 7, 13),
            'Dan državnosti - drugi dan' => CarbonImmutable::createFromDate($year, 7, 14),
            'Njegošev dan - prvi dan' => CarbonImmutable::createFromDate($year, 11, 13),
            'Njegošev dan - drugi dan' => CarbonImmutable::createFromDate($year, 11, 14),

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    public function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);

        return [
            'Vaskrs' => $orthodoxEaster,
            'Vaskršnji ponedjeljak' => $orthodoxEaster->copy()->addDay(),
            'Veliki petak' => $orthodoxEaster->copy()->subDays(2),
        ];
    }
}
