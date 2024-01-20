<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Bulgaria extends Country
{
    public function countryCode(): string
    {
        return 'bg';
    }

    /**
     * @param int $year
     * @return array<string, string>
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Нова година' => '01-01',
            'Ден на Освобождението на България от османско робство' => '03-03',
            'Ден на труда и на международната работническа солидарност' => '05-01',
            'Великден – християнската религия отбелязва Възкресение Христово' => '05-05',
            'Гергьовден, Ден на храбростта и Българската армия' => '05-06',
            'Денят на българската просвета и култура и на славянската писменост' => '05-24',
            'Съединението на България' => '09-06',
            'Ден на независимостта на България' => '09-22',
            'Коледа ден 1' => '12-24',
            'Коледа ден 2' => '12-25',
            'Коледа ден 3' => '12-26',
        ], $this->variableHolidays($year));
    }

    /**
     * @param int $year
     * @return array<string, string>
     */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Europe/Sofia');

        return [
            'Великден – християнската религия отбелязва Възкресение Христово' => $easter->format('m-d'),
        ];
    }

}
