<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Holiday;

class Sweden extends Country
{
    public function countryCode(): string
    {
        return 'se';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Nyårsdagen', "{$year}-01-01"),
            Holiday::national('Trettondedag jul', "{$year}-01-06"),
            Holiday::national('Första maj', "{$year}-05-01"),
            Holiday::national('Nationaldagen', "{$year}-06-06"),
            Holiday::national('Juldagen', "{$year}-12-25"),
            Holiday::national('Annandag jul', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $midsummerDay = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-06-20")->startOfDay();

        if (! $midsummerDay->isSaturday()) {
            $midsummerDay = $midsummerDay->next(CarbonInterface::SATURDAY)->toImmutable();
        }

        $halloween = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-10-31")->startOfDay();

        if (! $halloween->isSaturday()) {
            $halloween = $halloween->next(CarbonInterface::SATURDAY)->toImmutable();
        }

        return [
            Holiday::national('Långfredagen', $easter->subDays(2)),
            Holiday::national('Påskdagen', $easter),
            Holiday::national('Annandag påsk', $easter->addDay()),
            Holiday::national('Kristi himmelsfärdsdag', $easter->addDays(39)),
            Holiday::national('Pingstdagen', $easter->addDays(49)),
            Holiday::national('Midsommardagen', $midsummerDay->day > 26
                ? $midsummerDay->subWeek()
                : $midsummerDay),
            Holiday::national('Alla helgons dag', $halloween),
        ];
    }
}
