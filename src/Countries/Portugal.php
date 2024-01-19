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
            'Dia de Ano Novo' => '01-01',
            'Dia da Liberdade' => '04-25',
            'Dia do Trabalhador' => '05-01',
            'Dia de Portugal' => '06-10',
            'Assunção da Nossa Senhora' => '08-15',
            'Implantação da República' => '10-05',
            'Dia de Todos os Santos' => '11-01',
            'Restauração da Independência' => '12-01',
            'Imaculada Conceição' => '12-08',
            'Natal' => '12-25',
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
