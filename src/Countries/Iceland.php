<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Iceland extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'is';
    }

    public function defaultLocale(): string
    {
        return 'is';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            $this->fixedHolidays(),
            $this->variableHolidays($year),
        );
    }

    /** @return array<string, string> */
    protected function fixedHolidays(): array
    {
        return [
            'Nýársdagur' => '01-01',
            'Verkalýðsdagurinn' => '05-01',
            'Þjóðhátíðardagurinn' => '06-17',
            'Jóladagur' => '12-25',
            'Annar í jólum' => '12-26',
        ];
    }

    /** @return array<string, CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        // First Day of Summer: Thursday between 19 and 25 April
        $firstDayOfSummer = CarbonImmutable::createFromDate($year, 4, 19)->next(
            CarbonInterface::THURSDAY,
        );

        if ($firstDayOfSummer->day > 25) {
            $firstDayOfSummer = $firstDayOfSummer->subWeek();
        }

        // Commerce Day: First Monday in August
        $commerceDay = CarbonImmutable::createFromDate($year, 8, 1);
        if ($commerceDay->dayOfWeek !== CarbonInterface::MONDAY) {
            $commerceDay = $commerceDay->next(CarbonInterface::MONDAY);
        }

        return [
            'Skírdagur' => $easter->subDays(3),
            'Föstudagurinn langi' => $easter->subDays(2),
            'Páskadagur' => $easter,
            'Annar í páskum' => $easter->addDay(),
            'Sumardagurinn fyrsti' => $firstDayOfSummer,
            'Uppstigningardagur' => $easter->addDays(39),
            'Hvítasunnudagur' => $easter->addDays(49),
            'Annar í hvítasunnu' => $easter->addDays(50),
            'Frídagur verslunarmanna' => $commerceDay,
        ];
    }
}
