<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Montenegro extends Country
{
    public function countryCode(): string
    {
        return 'me';
    }

    protected function defaultLocale(): string
    {
        return 'sr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nova godina - prvi dan', "{$year}-01-01"),
            Holiday::national('Nova godina - drugi dan', "{$year}-01-02"),
            Holiday::national('Badnji dan', "{$year}-01-06"),
            Holiday::national('Božić - prvi dan', "{$year}-01-07"),
            Holiday::national('Božić - drugi dan', "{$year}-01-08"),
            Holiday::national('Praznik rada - prvi dan', "{$year}-05-01"),
            Holiday::national('Praznik rada - drugi dan', "{$year}-05-02"),
            Holiday::national('Dan nezavisnosti - prvi dan', "{$year}-05-21"),
            Holiday::national('Dan nezavisnosti - drugi dan', "{$year}-05-22"),
            Holiday::national('Dan državnosti - prvi dan', "{$year}-07-13"),
            Holiday::national('Dan državnosti - drugi dan', "{$year}-07-14"),
            Holiday::national('Njegošev dan - prvi dan', "{$year}-11-13"),
            Holiday::national('Njegošev dan - drugi dan', "{$year}-11-14"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    public function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);

        return [
            Holiday::national('Vaskrs', $orthodoxEaster),
            Holiday::national('Vaskršnji ponedjeljak', $orthodoxEaster->copy()->addDay()),
            Holiday::national('Veliki petak', $orthodoxEaster->copy()->subDays(2)),
        ];
    }
}
