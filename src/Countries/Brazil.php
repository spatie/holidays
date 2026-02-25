<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Brazil extends Country
{
    public function countryCode(): string
    {
        return 'br';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Dia de Ano Novo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Dia de Tiradentes' => CarbonImmutable::createFromDate($year, 4, 21),
            'Dia do Trabalhador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Independência do Brasil' => CarbonImmutable::createFromDate($year, 9, 7),
            'Nossa Senhora Aparecida' => CarbonImmutable::createFromDate($year, 10, 12),
            'Finados' => CarbonImmutable::createFromDate($year, 11, 2),
            'Proclamação da República' => CarbonImmutable::createFromDate($year, 11, 15),
            'Dia Nacional de Zumbi e da Consciência Negra' => CarbonImmutable::createFromDate($year, 11, 20),
            'Natal' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Carnaval' => $easter->subDays(47),
            'Sexta-feira Santa' => $easter->subDays(2),
            'Corpus Christi' => $easter->addDays(60),
        ];
    }
}
