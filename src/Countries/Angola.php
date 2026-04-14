<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Angola extends Country
{
    public function countryCode(): string
    {
        return 'ao';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Dia de Ano Novo', "{$year}-01-01"),
            Holiday::national('Dia do Inicio da Luta Armada de Libertação Nacional', "{$year}-02-04"),
            Holiday::national('Dia Internacional da Mulher', "{$year}-03-08"),
            Holiday::national('Dia da Paz', "{$year}-04-04"),
            Holiday::national('Dia Internacional do Trabalhador', "{$year}-05-01"),
            Holiday::national('Dia do Fundador da Nação e do Herói Nacional', "{$year}-09-17"),
            Holiday::national('Dia dos Finados', "{$year}-11-02"),
            Holiday::national('Dia da Independência Nacional', "{$year}-11-11"),
            Holiday::national('Dia do Natal', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Carnaval', $easter->subDays(47)),
            Holiday::national('Sexta Feira Santa', $easter->subDays(2)),
            Holiday::national('Páscoa', $easter),
        ];
    }
}
