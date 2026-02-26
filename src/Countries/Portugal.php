<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Portugal extends Country
{
    public function countryCode(): string
    {
        return 'pt';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Dia de Ano Novo', "{$year}-01-01"),
            Holiday::national('Dia da Liberdade', "{$year}-04-25"),
            Holiday::national('Dia do Trabalhador', "{$year}-05-01"),
            Holiday::national('Dia de Portugal', "{$year}-06-10"),
            Holiday::national('Assunção da Nossa Senhora', "{$year}-08-15"),
            Holiday::national('Implantação da República', "{$year}-10-05"),
            Holiday::national('Dia de Todos os Santos', "{$year}-11-01"),
            Holiday::national('Restauração da Independência', "{$year}-12-01"),
            Holiday::national('Imaculada Conceição', "{$year}-12-08"),
            Holiday::national('Natal', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Páscoa', $easter),
            Holiday::national('Sexta-feira Santa', $easter->subDays(2)),
            Holiday::national('Corpo de Deus', $easter->addDays(60)),
        ];
    }
}
