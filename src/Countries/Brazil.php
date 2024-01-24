<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Brazil extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    public function countryCode(): string
    {
        return 'br';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Dia de Ano Novo' => '01-01',
            'Dia de Tiradentes' => '04-21',
            'Dia do Trabalhador' => '05-01',
            'Independência do Brasil' => '09-07',
            'Nossa Senhora Aparecida' => '10-12',
            'Finados' => '11-02',
            'Proclamação da República' => '11-15',
            'Dia Nacional de Zumbi e da Consciência Negra' => '11-20',
            'Natal' => '12-25',
        ], $this->variableHolidays($year), $this->regionHolidays($year));
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

    /** @return array<string, CarbonImmutable|string> */
    protected function regionHolidays(int $year): array
    {
        switch ($this->region) {
            case 'BR-SP':
                return [
                    'Revolução Constitucionalista' => '05-09',
                ];
            case 'BR-SP-3550308':
                return [
                    'Aniversário da cidade de São Paulo' => '01-25',
                    'Corpus Christi' => '30-4',
                ];
            case 'BR-RJ':
                return [
                    'Carnaval' => '02-13',
                    'Dia de São Jorge' => '04-23',
                ];
        }


        return [];
    }
}
