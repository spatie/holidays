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
            'Dia de Ano Novo' => '01-01',
            'Dia do Inicio da Luta Armada de Libertação Nacional' => '02-04',
            'Dia Internacional da Mulher' => '03-08',
            'Dia da Paz' => '04-04',
            'Dia Internacional do Trabalhador' => '05-01',
            'Dia do Fundador da Nação e do Herói Nacional' => '09-17',
            'Dia dos Finados' => '11-02',
            'Dia da Independência Nacional' => '11-11',
            'Dia do Natal' => '12-25',
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
