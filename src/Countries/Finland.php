<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Holiday;

class Finland extends Country
{
    public function countryCode(): string
    {
        return 'fi';
    }

    protected function defaultLocale(): string
    {
        return 'fi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->fixedHolidays($year),
            $this->variableHolidays($year)
        );
    }

    /** @return array<Holiday> */
    protected function fixedHolidays(int $year): array
    {
        return [
            Holiday::national('Uudenvuodenpäivä', "{$year}-01-01"),
            Holiday::national('Loppiainen', "{$year}-01-06"),
            Holiday::national('Vappu', "{$year}-05-01"),
            Holiday::national('Itsenäisyyspäivä', "{$year}-12-06"),
            Holiday::national('Joulupäivä', "{$year}-12-25"),
            Holiday::national('Tapaninpäivä', "{$year}-12-26"),
        ];
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $midsummerDay = CarbonImmutable::createFromDate($year, 6, 20)
            ->next(CarbonInterface::SATURDAY)->toImmutable();

        return [
            Holiday::national('Pitkäperjantai', $easter->subDays(2)),
            Holiday::national('Pääsiäispäivä', $easter),
            Holiday::national('Toinen pääsiäispäivä', $easter->addDay()),
            Holiday::national('Helatorstai', $easter->addDays(39)),
            Holiday::national('Helluntaipäivä', $easter->addDays(49)),
            Holiday::national('Juhannuspäivä', $midsummerDay->day > 26
                ? $midsummerDay->subWeek()
                : $midsummerDay),
            Holiday::national('Pyhäinpäivä', CarbonImmutable::createFromDate($year, 10, 31)
                ->next(CarbonInterface::SATURDAY)->toImmutable()),
        ];
    }
}
