<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Angola extends Country
{
    public function countryCode(): string
    {
        return 'ao';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Dia de Ano Novo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Dia do Inicio da Luta Armada de Libertação Nacional' => CarbonImmutable::createFromDate($year, 2, 4),
            'Dia Internacional da Mulher' => CarbonImmutable::createFromDate($year, 3, 8),
            'Dia da Paz' => CarbonImmutable::createFromDate($year, 4, 4),
            'Dia Internacional do Trabalhador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Dia do Fundador da Nação e do Herói Nacional' => CarbonImmutable::createFromDate($year, 9, 17),
            'Dia dos Finados' => CarbonImmutable::createFromDate($year, 11, 2),
            'Dia da Independência Nacional' => CarbonImmutable::createFromDate($year, 11, 11),
            'Dia do Natal' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Carnaval' => $easter->subDays(47),
            'Sexta Feira Santa' => $easter->subDays(2),
            'Páscoa' => $easter,
        ];
    }
}
