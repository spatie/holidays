<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Finland extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'fi';
    }

    public function defaultLocale(): string
    {
        return 'fi';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->fixedHolidays(),
            $this->variableHolidays($year)
        );
    }

    /** @return array<string, string> */
    protected function fixedHolidays(): array
    {
        return [
            'Uudenvuodenpäivä' => '01-01',
            'Loppiainen' => '01-06',
            'Vappu' => '05-01',
            'Itsenäisyyspäivä' => '12-06',
            'Joulupäivä' => '12-25',
            'Tapaninpäivä' => '12-26',
        ];
    }

    /** @return array<string, CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $midsummerDay = CarbonImmutable::createFromDate($year, 6, 20)
            ->next(CarbonInterface::SATURDAY);

        return [
            'Pitkäperjantai' => $easter->subDays(2),
            'Pääsiäispäivä' => $easter,
            'Toinen pääsiäispäivä' => $easter->addDay(),
            'Helatorstai' => $easter->addDays(39),
            'Helluntaipäivä' => $easter->addDays(49),
            'Juhannuspäivä' => $midsummerDay->day > 26
                ? $midsummerDay->subWeek()
                : $midsummerDay,
            'Pyhäinpäivä' => CarbonImmutable::createFromDate($year, 10, 31)
                ->next(CarbonInterface::SATURDAY),
        ];
    }
}
