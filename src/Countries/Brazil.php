<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Brazil extends Country
{
    public function countryCode(): string
    {
        return 'br';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Dia de Ano Novo', "{$year}-01-01"),
            Holiday::national('Dia de Tiradentes', "{$year}-04-21"),
            Holiday::national('Dia do Trabalhador', "{$year}-05-01"),
            Holiday::national('Independência do Brasil', "{$year}-09-07"),
            Holiday::national('Nossa Senhora Aparecida', "{$year}-10-12"),
            Holiday::national('Finados', "{$year}-11-02"),
            Holiday::national('Proclamação da República', "{$year}-11-15"),
            Holiday::national('Dia Nacional de Zumbi e da Consciência Negra', "{$year}-11-20"),
            Holiday::national('Natal', "{$year}-12-25"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Carnaval', $easter->subDays(47)),
            Holiday::national('Sexta-feira Santa', $easter->subDays(2)),
            Holiday::national('Corpus Christi', $easter->addDays(60)),
        ];
    }
}
