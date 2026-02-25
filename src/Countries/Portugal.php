<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Portugal extends Country
{
    public function countryCode(): string
    {
        return 'pt';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Dia de Ano Novo' => CarbonImmutable::createFromDate($year, 1, 1),
            'Dia da Liberdade' => CarbonImmutable::createFromDate($year, 4, 25),
            'Dia do Trabalhador' => CarbonImmutable::createFromDate($year, 5, 1),
            'Dia de Portugal' => CarbonImmutable::createFromDate($year, 6, 10),
            'Assunção da Nossa Senhora' => CarbonImmutable::createFromDate($year, 8, 15),
            'Implantação da República' => CarbonImmutable::createFromDate($year, 10, 5),
            'Dia de Todos os Santos' => CarbonImmutable::createFromDate($year, 11, 1),
            'Restauração da Independência' => CarbonImmutable::createFromDate($year, 12, 1),
            'Imaculada Conceição' => CarbonImmutable::createFromDate($year, 12, 8),
            'Natal' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Páscoa' => $easter,
            'Sexta-feira Santa' => $easter->subDays(2),
            'Corpo de Deus' => $easter->addDays(60),
        ];
    }
}
