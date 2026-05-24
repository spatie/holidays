<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

class Brazil extends Country implements HasRegions
{
    protected function __construct(
        protected ?string $region = null,
    ) {
        if ($region !== null && ! in_array($region, static::regions())) {
            throw InvalidRegion::notFound($region);
        }
    }

    public static function regions(): array
    {
        return [
            'BR-AC', 'BR-AL', 'BR-AP', 'BR-AM', 'BR-BA', 'BR-CE', 'BR-DF',
            'BR-ES', 'BR-GO', 'BR-MA', 'BR-MG', 'BR-MS', 'BR-MT', 'BR-PA',
            'BR-PB', 'BR-PE', 'BR-PI', 'BR-PR', 'BR-RJ', 'BR-RN', 'BR-RO',
            'BR-RR', 'BR-RS', 'BR-SC', 'BR-SE', 'BR-SP', 'BR-TO',
        ];
    }

    public function region(): ?string
    {
        return $this->region;
    }

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
        ], $this->variableHolidays($year), $this->regionHolidays($year));
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

    /** @return array<Holiday> */
    protected function regionHolidays(int $year): array
    {
        if ($this->region === null) {
            return [];
        }

        $easter = $this->easter($year);

        switch ($this->region) {
            case 'BR-AC':
                return [
                    Holiday::regional('Dia do Evangélico', "{$year}-01-23", 'BR-AC'),
                    Holiday::regional('Aniversário do Acre', "{$year}-06-15", 'BR-AC'),
                    Holiday::regional('Dia da Amazônia', "{$year}-09-05", 'BR-AC'),
                    Holiday::regional('Tratado de Petrópolis', "{$year}-11-17", 'BR-AC'),
                ];
            case 'BR-AL':
                return [
                    Holiday::regional('São João', "{$year}-06-24", 'BR-AL'),
                    Holiday::regional('São Pedro', "{$year}-06-29", 'BR-AL'),
                    Holiday::regional('Emancipação Política de Alagoas', "{$year}-09-16", 'BR-AL'),
                ];
            case 'BR-AP':
                return [
                    Holiday::regional('São José', "{$year}-03-19", 'BR-AP'),
                    Holiday::regional('São Tiago', "{$year}-07-25", 'BR-AP'),
                    Holiday::regional('Criação do Estado do Amapá', "{$year}-10-05", 'BR-AP'),
                ];
            case 'BR-AM':
                return [
                    Holiday::regional('Elevação do Amazonas à categoria de Província', "{$year}-09-05", 'BR-AM'),
                    Holiday::regional('Nossa Senhora da Conceição', "{$year}-12-08", 'BR-AM'),
                ];
            case 'BR-BA':
                return [
                    Holiday::regional('Independência da Bahia', "{$year}-07-02", 'BR-BA'),
                ];
            case 'BR-CE':
                return [
                    Holiday::regional('São José', "{$year}-03-19", 'BR-CE'),
                    Holiday::regional('Abolição da Escravidão no Ceará', "{$year}-03-25", 'BR-CE'),
                ];
            case 'BR-DF':
                // Apr 21 (Fundação de Brasília) coincides with national Tiradentes — omitted to avoid duplication
                return [
                    Holiday::regional('Dia do Evangélico', "{$year}-11-30", 'BR-DF'),
                ];
            case 'BR-ES':
                // 2nd Monday after Easter (8 days after Easter Sunday)
                return [
                    Holiday::regional('Nossa Senhora da Penha', $easter->addDays(8), 'BR-ES'),
                ];
            case 'BR-GO':
                return [
                    Holiday::regional('Nossa Senhora Auxiliadora', "{$year}-05-24", 'BR-GO'),
                    Holiday::regional('Nossa Senhora de Sant\'Ana', "{$year}-07-26", 'BR-GO'),
                    Holiday::regional('Pedra Fundamental de Goiânia', "{$year}-10-24", 'BR-GO'),
                ];
            case 'BR-MA':
                return [
                    Holiday::regional('Adesão do Maranhão à Independência do Brasil', "{$year}-07-28", 'BR-MA'),
                    Holiday::regional('Nossa Senhora da Conceição', "{$year}-12-08", 'BR-MA'),
                ];
            case 'BR-MS':
                return [
                    Holiday::regional('Criação do Estado de Mato Grosso do Sul', "{$year}-10-11", 'BR-MS'),
                ];
            case 'BR-PA':
                return [
                    Holiday::regional('Adesão do Grão-Pará à Independência do Brasil', "{$year}-08-15", 'BR-PA'),
                    Holiday::regional('Nossa Senhora da Conceição', "{$year}-12-08", 'BR-PA'),
                ];
            case 'BR-PB':
                return [
                    Holiday::regional('Nossa Senhora das Neves', "{$year}-08-05", 'BR-PB'),
                ];
            case 'BR-PE':
                return [
                    Holiday::regional('Revolução Pernambucana', "{$year}-03-06", 'BR-PE'),
                    Holiday::regional('São João', "{$year}-06-24", 'BR-PE'),
                ];
            case 'BR-PI':
                return [
                    Holiday::regional('Dia da Batalha do Jenipapo', "{$year}-03-13", 'BR-PI'),
                    Holiday::regional('Dia do Piauí', "{$year}-10-19", 'BR-PI'),
                ];
            case 'BR-PR':
                return [
                    Holiday::regional('Emancipação Política do Paraná', "{$year}-12-19", 'BR-PR'),
                ];
            case 'BR-RJ':
                return [
                    Holiday::regional('São Jorge', "{$year}-04-23", 'BR-RJ'),
                ];
            case 'BR-RN':
                return [
                    Holiday::regional('Dia do Rio Grande do Norte', "{$year}-08-07", 'BR-RN'),
                    Holiday::regional('Mártires de Cunhaú e Uruaçu', "{$year}-10-03", 'BR-RN'),
                ];
            case 'BR-RO':
                return [
                    Holiday::regional('Criação do Estado de Rondônia', "{$year}-01-04", 'BR-RO'),
                    Holiday::regional('Dia do Evangélico', "{$year}-06-18", 'BR-RO'),
                ];
            case 'BR-RR':
                return [
                    Holiday::regional('Criação do Estado de Roraima', "{$year}-10-05", 'BR-RR'),
                ];
            case 'BR-RS':
                return [
                    Holiday::regional('Revolução Farroupilha', "{$year}-09-20", 'BR-RS'),
                ];
            case 'BR-SC':
                return [
                    Holiday::regional('Criação da Capitania de Santa Catarina', "{$year}-08-11", 'BR-SC'),
                    Holiday::regional('Santa Catarina de Alexandria', "{$year}-11-25", 'BR-SC'),
                ];
            case 'BR-SE':
                return [
                    Holiday::regional('Emancipação Política de Sergipe', "{$year}-07-08", 'BR-SE'),
                ];
            case 'BR-SP':
                return [
                    Holiday::regional('Revolução Constitucionalista de 1932', "{$year}-07-09", 'BR-SP'),
                ];
            case 'BR-TO':
                return [
                    Holiday::regional('Nossa Senhora da Natividade', "{$year}-09-08", 'BR-TO'),
                    Holiday::regional('Criação do Estado do Tocantins', "{$year}-10-05", 'BR-TO'),
                ];
        }

        return [];
    }
}
