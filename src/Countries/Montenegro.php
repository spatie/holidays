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

    public function allHolidays(int $year): array
    {
        // Montenegro has two days off for most holidays
        return array_merge([
            'Nova godina - prvi dan' => '01-01',
            'Nova godina - drugi dan' => '01-02',
            'Badnji dan' => '01-06',
            'Božić - prvi dan' => '01-07',
            'Božić - drugi dan' => '01-08',
            'Praznik rada - prvi dan' => '05-01',
            'Praznik rada - drugi dan' => '05-02',
            'Dan nezavisnosti - prvi dan' => '05-21',
            'Dan nezavisnosti - drugi dan' => '05-22',
            'Dan državnosti - prvi dan' => '07-13',
            'Dan državnosti - drugi dan' => '07-14',
            'Njegošev dan - prvi dan' => '11-13',
            'Njegošev dan - drugi dan' => '11-14',

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
