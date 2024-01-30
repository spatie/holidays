<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Sweden extends Country
{
    public function countryCode(): string
    {
        return 'se';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nyårsdagen' => '01-01',
            'Trettondedag jul' => '01-06',
            'Första maj' => '05-1',
            'Nationaldagen' => '06-6',
            'Juldagen' => '12-25',
            'Annandag jul' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year)->setTimezone('Europe/Stockholm');

        /** @var CarbonImmutable $midsummerDay */
        $midsummerDay = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-06-20", 'Europe/Stockholm');

        if (! $midsummerDay->isSaturday()) {
            $midsummerDay = $midsummerDay->next(CarbonImmutable::SATURDAY);
        }

        /** @var CarbonImmutable $halloween */
        $halloween = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-10-31", 'Europe/Stockholm');

        if (! $halloween->isSaturday()) {
            $halloween = $halloween->next(CarbonImmutable::SATURDAY);
        }

        return [
            'Långfredagen' => $easter->subDays(2),
            'Påskdagen' => $easter,
            'Annandag påsk' => $easter->addDay(),
            'Kristi himmelsfärdsdag' => $easter->addDays(39),
            'Pingstdagen' => $easter->addDays(49),
            'Midsommardagen' => $midsummerDay->day > 26
                ? $midsummerDay->subWeek()
                : $midsummerDay,
            'Alla helgons dag' => $halloween,
        ];
    }
}
