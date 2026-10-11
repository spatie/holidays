<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

class Portugal extends Country implements HasRegions
{
    protected function __construct(
        protected ?string $region = null,
    ) {
        if ($region !== null && ! in_array($region, static::regions())) {
            throw InvalidRegion::notFound($region);
        }
    }

    /**
     * Regions are municipalities, identified by `PT-` followed by their
     * DICO code (distrito + concelho) as published by the INE.
     *
     * @return array<string>
     */
    public static function regions(): array
    {
        return [
            ...static::getAveiroRegions(),
            ...static::getBejaRegions(),
            ...static::getBragaRegions(),
            ...static::getBragancaRegions(),
            ...static::getCasteloBrancoRegions(),
            ...static::getCoimbraRegions(),
            ...static::getEvoraRegions(),
            ...static::getFaroRegions(),
            ...static::getGuardaRegions(),
            ...static::getLeiriaRegions(),
            ...static::getLisboaRegions(),
            ...static::getPortalegreRegions(),
            ...static::getPortoRegions(),
            ...static::getSantaremRegions(),
            ...static::getSetubalRegions(),
            ...static::getVianaDoCasteloRegions(),
            ...static::getVilaRealRegions(),
            ...static::getViseuRegions(),
            ...static::getMadeiraRegions(),
            ...static::getAcoresRegions(),
        ];
    }

    public function region(): ?string
    {
        return $this->region;
    }

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
        ], $this->variableHolidays($year), $this->regionHolidays($year));
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

    /** @return array<Holiday> */
    protected function regionHolidays(int $year): array
    {
        if ($this->region === null) {
            return [];
        }

        return match (substr($this->region, 3, 2)) {
            '01' => $this->getAveiroHolidays($year),
            '02' => $this->getBejaHolidays($year),
            '03' => $this->getBragaHolidays($year),
            '04' => $this->getBragancaHolidays($year),
            '05' => $this->getCasteloBrancoHolidays($year),
            '06' => $this->getCoimbraHolidays($year),
            '07' => $this->getEvoraHolidays($year),
            '08' => $this->getFaroHolidays($year),
            '09' => $this->getGuardaHolidays($year),
            '10' => $this->getLeiriaHolidays($year),
            '11' => $this->getLisboaHolidays($year),
            '12' => $this->getPortalegreHolidays($year),
            '13' => $this->getPortoHolidays($year),
            '14' => $this->getSantaremHolidays($year),
            '15' => $this->getSetubalHolidays($year),
            '16' => $this->getVianaDoCasteloHolidays($year),
            '17' => $this->getVilaRealHolidays($year),
            '18' => $this->getViseuHolidays($year),
            '31', '32' => $this->getMadeiraHolidays($year),
            '41', '42', '43', '44', '45', '46', '47', '48', '49' => $this->getAcoresHolidays($year),
            default => [],
        };
    }

    protected function getEasterBasedDate(int $year, int $days): CarbonImmutable
    {
        return $this->easter($year)->addDays($days);
    }

    // Easter-based holidays

    protected function getSegundaFeiraDePascoaHoliday(int $year): Holiday
    {
        return Holiday::regional('Segunda-feira de Páscoa', $this->getEasterBasedDate($year, 1), $this->region);
    }

    protected function getQuintaFeiraDaAscensaoHoliday(int $year): Holiday
    {
        return Holiday::regional('Quinta-feira da Ascensão', $this->getEasterBasedDate($year, 39), $this->region);
    }

    // Popular saints holidays

    protected function getSantoAntonioHoliday(int $year): Holiday
    {
        return Holiday::regional('Santo António', "{$year}-06-13", $this->region);
    }

    protected function getSaoJoaoHoliday(int $year): Holiday
    {
        return Holiday::regional('São João Baptista', "{$year}-06-24", $this->region);
    }

    protected function getSaoPedroHoliday(int $year): Holiday
    {
        return Holiday::regional('São Pedro', "{$year}-06-29", $this->region);
    }

    // Religious holidays

    protected function getSaoVicenteHoliday(int $year): Holiday
    {
        return Holiday::regional('São Vicente', "{$year}-01-22", $this->region);
    }

    protected function getSaoJoseHoliday(int $year): Holiday
    {
        return Holiday::regional('São José', "{$year}-03-19", $this->region);
    }

    protected function getSaoBentoHoliday(int $year): Holiday
    {
        return Holiday::regional('São Bento', "{$year}-07-11", $this->region);
    }

    protected function getSantaMariaMadalenaHoliday(int $year): Holiday
    {
        return Holiday::regional('Santa Maria Madalena', "{$year}-07-22", $this->region);
    }

    protected function getSaoTiagoHoliday(int $year): Holiday
    {
        return Holiday::regional('São Tiago', "{$year}-07-25", $this->region);
    }

    protected function getSaoLourencoHoliday(int $year): Holiday
    {
        return Holiday::regional('São Lourenço', "{$year}-08-10", $this->region);
    }

    protected function getNossaSenhoraDoSocorroHoliday(int $year): Holiday
    {
        return Holiday::regional('Nossa Senhora do Socorro', "{$year}-08-16", $this->region);
    }

    protected function getSaoBernardoHoliday(int $year): Holiday
    {
        return Holiday::regional('São Bernardo', "{$year}-08-20", $this->region);
    }

    protected function getSaoBartolomeuHoliday(int $year): Holiday
    {
        return Holiday::regional('São Bartolomeu', "{$year}-08-24", $this->region);
    }

    protected function getNossaSenhoraDaLuzHoliday(int $year): Holiday
    {
        return Holiday::regional('Nossa Senhora da Luz', "{$year}-09-08", $this->region);
    }

    protected function getSaoMateusHoliday(int $year): Holiday
    {
        return Holiday::regional('São Mateus', "{$year}-09-21", $this->region);
    }

    protected function getSaoMiguelArcanjoHoliday(int $year): Holiday
    {
        return Holiday::regional('São Miguel Arcanjo', "{$year}-09-29", $this->region);
    }

    protected function getSaoMartinhoHoliday(int $year): Holiday
    {
        return Holiday::regional('São Martinho', "{$year}-11-11", $this->region);
    }

    /** @return array<string> */
    protected static function getAveiroRegions(): array
    {
        return [
            'PT-0101', 'PT-0102', 'PT-0103', 'PT-0104', 'PT-0105', 'PT-0106', 'PT-0107', 'PT-0108',
            'PT-0109', 'PT-0110', 'PT-0111', 'PT-0112', 'PT-0113', 'PT-0114', 'PT-0115', 'PT-0116',
            'PT-0117', 'PT-0118', 'PT-0119',
        ];
    }

    /** @return array<Holiday> */
    protected function getAveiroHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0101' => [Holiday::regional('Feriado Municipal de Águeda', $this->getEasterBasedDate($year, 50), $this->region)], // Águeda
            'PT-0102' => [Holiday::regional('Segunda-feira da Senhora do Socorro', CarbonImmutable::parse("third sunday of august {$year}")->addDay(), $this->region)], // Albergaria-a-Velha
            'PT-0103' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Anadia
            'PT-0104' => [Holiday::regional('Rainha Santa Mafalda', "{$year}-05-02", $this->region)], // Arouca
            'PT-0105' => [Holiday::regional('Santa Joana Princesa', "{$year}-05-12", $this->region)], // Aveiro
            'PT-0106' => [$this->getSaoJoaoHoliday($year)], // Castelo de Paiva
            'PT-0107' => [Holiday::regional('Dia da Cidade de Espinho', "{$year}-06-16", $this->region)], // Espinho
            'PT-0108' => [$this->getSantoAntonioHoliday($year)], // Estarreja
            'PT-0110' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Ílhavo
            'PT-0111' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Mealhada
            'PT-0112' => [Holiday::regional('Nossa Senhora da Natividade', "{$year}-09-08", $this->region)], // Murtosa
            'PT-0113' => [Holiday::regional('Nossa Senhora de La Salette', CarbonImmutable::parse("second sunday of august {$year}")->addDay(), $this->region)], // Oliveira de Azeméis
            'PT-0114' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Oliveira do Bairro
            'PT-0115' => [Holiday::regional('São Cristóvão', "{$year}-07-25", $this->region)], // Ovar
            'PT-0109' => [Holiday::regional('São Sebastião', "{$year}-01-20", $this->region)], // Santa Maria da Feira
            'PT-0116' => [Holiday::regional('Elevação a cidade e fundação do município', "{$year}-10-11", $this->region)], // São João da Madeira
            'PT-0117' => [$this->getSaoMateusHoliday($year)], // Sever do Vouga
            'PT-0118' => [Holiday::regional('Dia do Município e Nossa Senhora de Vagos', $this->getEasterBasedDate($year, 50), $this->region)], // Vagos
            'PT-0119' => [$this->getSantoAntonioHoliday($year)], // Vale de Cambra
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getBejaRegions(): array
    {
        return [
            'PT-0201', 'PT-0202', 'PT-0203', 'PT-0204', 'PT-0205', 'PT-0206', 'PT-0207', 'PT-0208',
            'PT-0209', 'PT-0210', 'PT-0211', 'PT-0212', 'PT-0213', 'PT-0214',
        ];
    }

    /** @return array<Holiday> */
    protected function getBejaHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0201' => [$this->getSantoAntonioHoliday($year)], // Aljustrel
            'PT-0202' => [$this->getSaoJoaoHoliday($year)], // Almodôvar
            'PT-0203' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Alvito
            'PT-0204' => [Holiday::regional('Festa de Nossa Senhora da Conceição', "{$year}-08-28", $this->region)], // Barrancos
            'PT-0205' => [Holiday::regional('Dia da Espiga', $this->getEasterBasedDate($year, 39), $this->region)], // Beja
            'PT-0206' => [$this->getSaoPedroHoliday($year)], // Castro Verde
            'PT-0207' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Cuba
            'PT-0208' => [Holiday::regional('Outorgação do foral manuelino', "{$year}-03-05", $this->region)], // Ferreira do Alentejo
            'PT-0209' => [$this->getSaoJoaoHoliday($year)], // Mértola
            'PT-0210' => [$this->getSaoJoaoHoliday($year)], // Moura
            'PT-0211' => [Holiday::regional('Nossa Senhora da Piedade', "{$year}-09-08", $this->region)], // Odemira
            'PT-0212' => [Holiday::regional('Nossa Senhora da Cola', "{$year}-09-08", $this->region)], // Ourique
            'PT-0213' => [Holiday::regional('Nossa Senhora de Guadalupe', $this->getEasterBasedDate($year, 2), $this->region)], // Serpa
            'PT-0214' => [Holiday::regional('Dia da Espiga', $this->getEasterBasedDate($year, 39), $this->region)], // Vidigueira
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getBragaRegions(): array
    {
        return [
            'PT-0301', 'PT-0302', 'PT-0303', 'PT-0304', 'PT-0305', 'PT-0306', 'PT-0307', 'PT-0308',
            'PT-0309', 'PT-0310', 'PT-0311', 'PT-0312', 'PT-0313', 'PT-0314',
        ];
    }

    /** @return array<Holiday> */
    protected function getBragaHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0301' => [$this->getSantoAntonioHoliday($year)], // Amares
            'PT-0302' => [Holiday::regional('Santa Cruz', "{$year}-05-03", $this->region)], // Barcelos
            'PT-0303' => [$this->getSaoJoaoHoliday($year)], // Braga
            'PT-0304' => [$this->getSaoMiguelArcanjoHoliday($year)], // Cabeceiras de Basto
            'PT-0305' => [$this->getSaoTiagoHoliday($year)], // Celorico de Basto
            'PT-0306' => [Holiday::regional('Elevação a vila', "{$year}-08-19", $this->region)], // Esposende
            'PT-0307' => [Holiday::regional('Feiras Francas', "{$year}-05-16", $this->region)], // Fafe
            'PT-0308' => [Holiday::regional('Batalha de São Mamede', "{$year}-06-24", $this->region)], // Guimarães
            'PT-0309' => [$this->getSaoJoseHoliday($year)], // Póvoa de Lanhoso
            'PT-0310' => [Holiday::regional('Foral de D. Manuel I', "{$year}-10-20", $this->region)], // Terras de Bouro
            'PT-0311' => [Holiday::regional('Feira da Ladra', CarbonImmutable::parse("first saturday of october {$year}")->addDays(2), $this->region)], // Vieira do Minho
            'PT-0312' => [$this->getSantoAntonioHoliday($year)], // Vila Nova de Famalicão
            'PT-0313' => [$this->getSantoAntonioHoliday($year)], // Vila Verde
            'PT-0314' => [Holiday::regional('Restauração do município', "{$year}-03-19", $this->region), $this->getSaoJoseHoliday($year)], // Vizela
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getBragancaRegions(): array
    {
        return [
            'PT-0401', 'PT-0402', 'PT-0403', 'PT-0404', 'PT-0405', 'PT-0406', 'PT-0407', 'PT-0408',
            'PT-0409', 'PT-0410', 'PT-0411', 'PT-0412',
        ];
    }

    /** @return array<Holiday> */
    protected function getBragancaHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0401' => [Holiday::regional('Foral de D. Dinis', "{$year}-05-08", $this->region)], // Alfândega da Fé
            'PT-0402' => [Holiday::regional('Nossa Senhora das Graças', "{$year}-08-22", $this->region)], // Bragança
            'PT-0403' => [Holiday::regional('Feriado Municipal de Carrazeda de Ansiães', "{$year}-08-31", $this->region)], // Carrazeda de Ansiães
            'PT-0404' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Freixo de Espada à Cinta
            'PT-0405' => [$this->getSaoPedroHoliday($year)], // Macedo de Cavaleiros
            'PT-0406' => [Holiday::regional('Elevação a cidade', "{$year}-07-10", $this->region)], // Miranda do Douro
            'PT-0407' => [Holiday::regional('Outorgação do Foral de D. Afonso III', "{$year}-05-25", $this->region)], // Mirandela
            'PT-0408' => [Holiday::regional('Feira dos Gorazes', "{$year}-10-15", $this->region)], // Mogadouro
            'PT-0409' => [$this->getSaoJoseHoliday($year)], // Torre de Moncorvo
            'PT-0410' => [$this->getSaoBartolomeuHoliday($year)], // Vila Flor
            'PT-0411' => [$this->getSaoLourencoHoliday($year)], // Vimioso
            'PT-0412' => [Holiday::regional('Outorgação do Foral Manuelino', "{$year}-05-20", $this->region)], // Vinhais
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getCasteloBrancoRegions(): array
    {
        return [
            'PT-0501', 'PT-0502', 'PT-0503', 'PT-0504', 'PT-0505', 'PT-0506', 'PT-0507', 'PT-0508',
            'PT-0509', 'PT-0510', 'PT-0511',
        ];
    }

    /** @return array<Holiday> */
    protected function getCasteloBrancoHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0501' => [Holiday::regional('Primeira missa no Brasil', "{$year}-04-26", $this->region)], // Belmonte
            'PT-0502' => [Holiday::regional('Nossa Senhora de Mércoles', $this->getEasterBasedDate($year, 2), $this->region)], // Castelo Branco
            'PT-0503' => [Holiday::regional('Elevação a cidade', "{$year}-10-20", $this->region)], // Covilhã
            'PT-0504' => [Holiday::regional('Santa Luzia', "{$year}-09-15", $this->region)], // Fundão
            'PT-0505' => [Holiday::regional('Nossa Senhora do Almortão', $this->getEasterBasedDate($year, 15), $this->region)], // Idanha-a-Nova
            'PT-0506' => [Holiday::regional('Santa Margarida', CarbonImmutable::parse("second sunday of august {$year}")->addDay(), $this->region)], // Oleiros
            'PT-0507' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Penamacor
            'PT-0508' => [$this->getSantoAntonioHoliday($year)], // Proença-a-Nova
            'PT-0509' => [Holiday::regional('São Nuno de Santa Maria', "{$year}-06-24", $this->region)], // Sertã
            'PT-0510' => [Holiday::regional('Recebimento do Foral de D. Dinis', "{$year}-09-19", $this->region)], // Vila de Rei
            'PT-0511' => [Holiday::regional('Nossa Senhora da Alagada', CarbonImmutable::parse("fourth sunday of august {$year}")->addDay(), $this->region)], // Vila Velha de Ródão
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getCoimbraRegions(): array
    {
        return [
            'PT-0601', 'PT-0602', 'PT-0603', 'PT-0604', 'PT-0605', 'PT-0606', 'PT-0607', 'PT-0608',
            'PT-0609', 'PT-0610', 'PT-0611', 'PT-0612', 'PT-0613', 'PT-0614', 'PT-0615', 'PT-0616',
            'PT-0617',
        ];
    }

    /** @return array<Holiday> */
    protected function getCoimbraHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0601' => [Holiday::regional('Nossa Senhora do Mont\'Alto', "{$year}-09-07", $this->region)], // Arganil
            'PT-0602' => [$this->getSaoTiagoHoliday($year)], // Cantanhede
            'PT-0603' => [Holiday::regional('Rainha Santa Isabel', "{$year}-07-04", $this->region)], // Coimbra
            'PT-0604' => [Holiday::regional('Santa Cristina', "{$year}-07-24", $this->region)], // Condeixa-a-Nova
            'PT-0605' => [$this->getSaoJoaoHoliday($year)], // Figueira da Foz
            'PT-0606' => [Holiday::regional('Doação de Góis a Anaia Vestrares', "{$year}-08-13", $this->region)], // Góis
            'PT-0607' => [$this->getSaoJoaoHoliday($year)], // Lousã
            'PT-0608' => [Holiday::regional('São Tomé', "{$year}-07-25", $this->region)], // Mira
            'PT-0609' => [Holiday::regional('Nascimento de José Falcão', "{$year}-06-01", $this->region)], // Miranda do Corvo
            'PT-0610' => [Holiday::regional('Nossa Senhora da Vitória', "{$year}-09-08", $this->region)], // Montemor-o-Velho
            'PT-0611' => [Holiday::regional('Recebimento da notícia da Implantação da República', "{$year}-10-07", $this->region)], // Oliveira do Hospital
            'PT-0612' => [Holiday::regional('Restauração dos títulos de vila isenta', "{$year}-04-10", $this->region)], // Pampilhosa da Serra
            'PT-0613' => [Holiday::regional('Nascimento de António José de Almeida', "{$year}-07-17", $this->region)], // Penacova
            'PT-0614' => [$this->getSaoMiguelArcanjoHoliday($year)], // Penela
            'PT-0615' => [$this->getSaoMateusHoliday($year)], // Soure
            'PT-0616' => [Holiday::regional('Restauração da Comarca', "{$year}-04-10", $this->region)], // Tábua
            'PT-0617' => [Holiday::regional('Restauração do município', "{$year}-01-13", $this->region)], // Vila Nova de Poiares
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getEvoraRegions(): array
    {
        return [
            'PT-0701', 'PT-0702', 'PT-0703', 'PT-0704', 'PT-0705', 'PT-0706', 'PT-0707', 'PT-0708',
            'PT-0709', 'PT-0710', 'PT-0711', 'PT-0712', 'PT-0713', 'PT-0714',
        ];
    }

    /** @return array<Holiday> */
    protected function getEvoraHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0701' => [Holiday::regional('Segunda-feira de Pascoela (Nossa Senhora da Boa Nova)', $this->getEasterBasedDate($year, 8), $this->region)], // Alandroal
            'PT-0702' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Arraiolos
            'PT-0703' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Borba
            'PT-0704' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Estremoz
            'PT-0705' => [$this->getSaoPedroHoliday($year)], // Évora
            'PT-0706' => [Holiday::regional('São João de Deus', "{$year}-03-08", $this->region)], // Montemor-o-Novo
            'PT-0707' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Mora
            'PT-0708' => [Holiday::regional('Nossa Senhora das Candeias', "{$year}-02-02", $this->region)], // Mourão
            'PT-0709' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Portel
            'PT-0710' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Redondo
            'PT-0711' => [$this->getSantoAntonioHoliday($year)], // Reguengos de Monsaraz
            'PT-0712' => [Holiday::regional('Elevação a concelho', "{$year}-09-07", $this->region)], // Vendas Novas
            'PT-0713' => [Holiday::regional('Restauração do concelho', "{$year}-01-13", $this->region)], // Viana do Alentejo
            'PT-0714' => [Holiday::regional('Nascimento de Couto Jardim', "{$year}-08-16", $this->region)], // Vila Viçosa
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getFaroRegions(): array
    {
        return [
            'PT-0801', 'PT-0802', 'PT-0803', 'PT-0804', 'PT-0805', 'PT-0806', 'PT-0807', 'PT-0808',
            'PT-0809', 'PT-0810', 'PT-0811', 'PT-0812', 'PT-0813', 'PT-0814', 'PT-0815', 'PT-0816',
        ];
    }

    /** @return array<Holiday> */
    protected function getFaroHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0801' => [Holiday::regional('Foral de D. Manuel I', "{$year}-08-20", $this->region)], // Albufeira
            'PT-0802' => [Holiday::regional('Festas de Alcoutim', CarbonImmutable::parse("second friday of september {$year}"), $this->region)], // Alcoutim
            'PT-0803' => [Holiday::regional('Banho Santo', "{$year}-08-29", $this->region)], // Aljezur
            'PT-0804' => [$this->getSaoJoaoHoliday($year)], // Castro Marim
            'PT-0805' => [Holiday::regional('Elevação a cidade', "{$year}-09-07", $this->region)], // Faro
            'PT-0806' => [$this->getNossaSenhoraDaLuzHoliday($year)], // Lagoa
            'PT-0807' => [Holiday::regional('São Gonçalo de Lagos', "{$year}-10-27", $this->region)], // Lagos
            'PT-0808' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Loulé
            'PT-0809' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Monchique
            'PT-0810' => [Holiday::regional('Revolta de Olhão contra os Franceses', "{$year}-06-16", $this->region)], // Olhão
            'PT-0811' => [Holiday::regional('Elevação a cidade', "{$year}-12-11", $this->region)], // Portimão
            'PT-0812' => [Holiday::regional('Elevação a município', "{$year}-06-01", $this->region)], // São Brás de Alportel
            'PT-0813' => [Holiday::regional('Conquista da cidade aos Mouros', "{$year}-09-03", $this->region)], // Silves
            'PT-0814' => [$this->getSaoJoaoHoliday($year)], // Tavira
            'PT-0815' => [$this->getSaoVicenteHoliday($year)], // Vila do Bispo
            'PT-0816' => [Holiday::regional('Elevação a cidade', "{$year}-05-13", $this->region)], // Vila Real de Santo António
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getGuardaRegions(): array
    {
        return [
            'PT-0901', 'PT-0902', 'PT-0903', 'PT-0904', 'PT-0905', 'PT-0906', 'PT-0907', 'PT-0908',
            'PT-0909', 'PT-0910', 'PT-0911', 'PT-0912', 'PT-0913', 'PT-0914',
        ];
    }

    /** @return array<Holiday> */
    protected function getGuardaHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-0901' => [Holiday::regional('Restauração do concelho', "{$year}-02-10", $this->region)], // Aguiar da Beira
            'PT-0902' => [Holiday::regional('Batalha do Côa', "{$year}-07-02", $this->region)], // Almeida
            'PT-0903' => [Holiday::regional('Nascimento de Sacadura Cabral', "{$year}-05-23", $this->region)], // Celorico da Beira
            'PT-0904' => [Holiday::regional('Batalha de Salgadela', "{$year}-07-07", $this->region)], // Figueira de Castelo Rodrigo
            'PT-0905' => [$this->getSaoMiguelArcanjoHoliday($year)], // Fornos de Algodres
            'PT-0906' => [Holiday::regional('Nosso Senhor do Calvário', CarbonImmutable::parse("second sunday of august {$year}")->addDay(), $this->region)], // Gouveia
            'PT-0907' => [Holiday::regional('Foral de D. Sancho I', "{$year}-11-27", $this->region)], // Guarda
            'PT-0908' => [Holiday::regional('Outorgação do Foral', "{$year}-03-04", $this->region)], // Manteigas
            'PT-0909' => [$this->getSaoMartinhoHoliday($year)], // Mêda
            'PT-0910' => [Holiday::regional('Elevação a cidade', "{$year}-08-25", $this->region)], // Pinhel
            'PT-0911' => [Holiday::regional('Segunda-feira de Pascoela (Nossa Senhora dos Prazeres / Nossa Senhora da Graça)', $this->getEasterBasedDate($year, 8), $this->region)], // Sabugal
            'PT-0912' => [Holiday::regional('Elevação a cidade', "{$year}-07-03", $this->region)], // Seia
            'PT-0913' => [Holiday::regional('Batalha de São Marcos', "{$year}-05-29", $this->region)], // Trancoso
            'PT-0914' => [Holiday::regional('Outorgação do foral de D. Dinis', "{$year}-05-21", $this->region)], // Vila Nova de Foz Côa
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getLeiriaRegions(): array
    {
        return [
            'PT-1001', 'PT-1002', 'PT-1003', 'PT-1004', 'PT-1005', 'PT-1006', 'PT-1007', 'PT-1008',
            'PT-1009', 'PT-1010', 'PT-1011', 'PT-1012', 'PT-1013', 'PT-1014', 'PT-1015', 'PT-1016',
        ];
    }

    /** @return array<Holiday> */
    protected function getLeiriaHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1001' => [$this->getSaoBernardoHoliday($year)], // Alcobaça
            'PT-1002' => [$this->getSantoAntonioHoliday($year)], // Alvaiázere
            'PT-1003' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Ansião
            'PT-1004' => [Holiday::regional('Batalha de Aljubarrota', "{$year}-08-14", $this->region)], // Batalha
            'PT-1005' => [$this->getSaoPedroHoliday($year)], // Bombarral
            'PT-1006' => [Holiday::regional('Fundação da localidade pela rainha D. Leonor', "{$year}-05-15", $this->region)], // Caldas da Rainha
            'PT-1007' => [Holiday::regional('Fundação do município', "{$year}-07-04", $this->region)], // Castanheira de Pera
            'PT-1008' => [$this->getSaoJoaoHoliday($year)], // Figueiró dos Vinhos
            'PT-1009' => [Holiday::regional('Elevação a cidade e fundação da diocese', "{$year}-05-22", $this->region)], // Leiria
            'PT-1010' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Marinha Grande
            'PT-1011' => [Holiday::regional('Nossa Senhora das Areias (ou da Nazaré)', "{$year}-09-08", $this->region)], // Nazaré
            'PT-1012' => [Holiday::regional('Tomada de Óbidos aos Mouros', "{$year}-01-11", $this->region)], // Óbidos
            'PT-1013' => [Holiday::regional('Criação do município', "{$year}-07-24", $this->region)], // Pedrógão Grande
            'PT-1014' => [Holiday::regional('Nossa Senhora da Boa Viagem', CarbonImmutable::parse("first sunday of august {$year}")->addDay(), $this->region)], // Peniche
            'PT-1015' => [$this->getSaoMartinhoHoliday($year)], // Pombal
            'PT-1016' => [$this->getSaoPedroHoliday($year)], // Porto de Mós
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getLisboaRegions(): array
    {
        return [
            'PT-1101', 'PT-1102', 'PT-1103', 'PT-1104', 'PT-1105', 'PT-1106', 'PT-1107', 'PT-1108',
            'PT-1109', 'PT-1110', 'PT-1111', 'PT-1112', 'PT-1113', 'PT-1114', 'PT-1115', 'PT-1116',
        ];
    }

    /** @return array<Holiday> */
    protected function getLisboaHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1101' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Alenquer
            'PT-1115' => [Holiday::regional('Criação do município', "{$year}-09-11", $this->region)], // Amadora
            'PT-1102' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Arruda dos Vinhos
            'PT-1103' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Azambuja
            'PT-1104' => [Holiday::regional('Restauração do município', "{$year}-01-13", $this->region)], // Cadaval
            'PT-1105' => [$this->getSantoAntonioHoliday($year)], // Cascais
            'PT-1106' => [$this->getSantoAntonioHoliday($year)], // Lisboa
            'PT-1107' => [Holiday::regional('Criação do município', "{$year}-07-26", $this->region)], // Loures
            'PT-1108' => [$this->getSaoJoaoHoliday($year)], // Lourinhã
            'PT-1109' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Mafra
            'PT-1116' => [Holiday::regional('Criação do município', "{$year}-11-19", $this->region)], // Odivelas
            'PT-1110' => [Holiday::regional('Criação do município', "{$year}-06-07", $this->region)], // Oeiras
            'PT-1111' => [$this->getSaoPedroHoliday($year)], // Sintra
            'PT-1112' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Sobral de Monte Agraço
            'PT-1113' => [$this->getSaoMartinhoHoliday($year)], // Torres Vedras
            'PT-1114' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Vila Franca de Xira
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getPortalegreRegions(): array
    {
        return [
            'PT-1201', 'PT-1202', 'PT-1203', 'PT-1204', 'PT-1205', 'PT-1206', 'PT-1207', 'PT-1208',
            'PT-1209', 'PT-1210', 'PT-1211', 'PT-1212', 'PT-1213', 'PT-1214', 'PT-1215',
        ];
    }

    /** @return array<Holiday> */
    protected function getPortalegreHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1201' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Alter do Chão
            'PT-1202' => [$this->getSaoJoaoHoliday($year)], // Arronches
            'PT-1203' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Avis
            'PT-1204' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Campo Maior
            'PT-1205' => [Holiday::regional('Nossa Senhora da Luz', $this->getEasterBasedDate($year, 1), $this->region)], // Castelo de Vide
            'PT-1206' => [Holiday::regional('São Gregório', $this->getEasterBasedDate($year, 1), $this->region)], // Crato
            'PT-1207' => [Holiday::regional('Batalha das Linhas de Elvas', "{$year}-01-14", $this->region)], // Elvas
            'PT-1208' => [Holiday::regional('Batalha dos Atoleiros', "{$year}-04-06", $this->region)], // Fronteira
            'PT-1209' => [Holiday::regional('Recebimento do Foral Manuelino', "{$year}-11-23", $this->region)], // Gavião
            'PT-1210' => [Holiday::regional('Nossa Senhora da Estrela', "{$year}-09-08", $this->region)], // Marvão
            'PT-1211' => [Holiday::regional('Segunda-feira de Pascoela (Nossa Senhora dos Prazeres)', $this->getEasterBasedDate($year, 8), $this->region)], // Monforte
            'PT-1212' => [Holiday::regional('Nossa Senhora da Graça', $this->getEasterBasedDate($year, 1), $this->region)], // Nisa
            'PT-1213' => [Holiday::regional('Festa da Salgueirinha', $this->getEasterBasedDate($year, 1), $this->region)], // Ponte de Sor
            'PT-1214' => [Holiday::regional('Elevação a cidade e fundação da diocese', "{$year}-05-23", $this->region)], // Portalegre
            'PT-1215' => [Holiday::regional('Nossa Senhora do Carmo da Serra (de São Miguel)', $this->getEasterBasedDate($year, 1), $this->region)], // Sousel
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getPortoRegions(): array
    {
        return [
            'PT-1301', 'PT-1302', 'PT-1303', 'PT-1304', 'PT-1305', 'PT-1306', 'PT-1307', 'PT-1308',
            'PT-1309', 'PT-1310', 'PT-1311', 'PT-1312', 'PT-1313', 'PT-1314', 'PT-1315', 'PT-1316',
            'PT-1317', 'PT-1318',
        ];
    }

    /** @return array<Holiday> */
    protected function getPortoHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1301' => [Holiday::regional('Elevação a cidade', "{$year}-07-08", $this->region)], // Amarante
            'PT-1302' => [$this->getSaoBartolomeuHoliday($year)], // Baião
            'PT-1303' => [$this->getSaoPedroHoliday($year)], // Felgueiras
            'PT-1304' => [Holiday::regional('Nossa Senhora do Rosário', CarbonImmutable::parse("first sunday of october {$year}")->addDay(), $this->region)], // Gondomar
            'PT-1305' => [Holiday::regional('Nosso Senhor dos Aflitos', CarbonImmutable::parse("last sunday of july {$year}")->addDay(), $this->region)], // Lousada
            'PT-1306' => [Holiday::regional('Nossa Senhora do Bom Despacho', CarbonImmutable::parse("second sunday of july {$year}")->addDay(), $this->region)], // Maia
            'PT-1307' => [Holiday::regional('Nossa Senhora da Natividade do Castelinho', "{$year}-09-08", $this->region)], // Marco de Canaveses
            'PT-1308' => [Holiday::regional('Terça-feira de Pentecostes', $this->getEasterBasedDate($year, 51), $this->region)], // Matosinhos
            'PT-1309' => [Holiday::regional('Criação do município', "{$year}-11-06", $this->region)], // Paços de Ferreira
            'PT-1310' => [Holiday::regional('Divino Salvador', CarbonImmutable::parse("third sunday of july {$year}")->addDay(), $this->region)], // Paredes
            'PT-1311' => [$this->getSaoMartinhoHoliday($year)], // Penafiel
            'PT-1312' => [$this->getSaoJoaoHoliday($year)], // Porto
            'PT-1313' => [$this->getSaoPedroHoliday($year)], // Póvoa de Varzim
            'PT-1314' => [$this->getSaoBentoHoliday($year)], // Santo Tirso
            'PT-1315' => [$this->getSaoJoaoHoliday($year)], // Valongo
            'PT-1316' => [$this->getSaoJoaoHoliday($year)], // Vila do Conde
            'PT-1317' => [$this->getSaoJoaoHoliday($year)], // Vila Nova de Gaia
            'PT-1318' => [Holiday::regional('Criação do município', "{$year}-11-19", $this->region)], // Trofa
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getSantaremRegions(): array
    {
        return [
            'PT-1401', 'PT-1402', 'PT-1403', 'PT-1404', 'PT-1405', 'PT-1406', 'PT-1407', 'PT-1408',
            'PT-1409', 'PT-1410', 'PT-1411', 'PT-1412', 'PT-1413', 'PT-1414', 'PT-1415', 'PT-1416',
            'PT-1417', 'PT-1418', 'PT-1419', 'PT-1420', 'PT-1421',
        ];
    }

    /** @return array<Holiday> */
    protected function getSantaremHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1401' => [Holiday::regional('Elevação a cidade', "{$year}-06-14", $this->region)], // Abrantes
            'PT-1402' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Alcanena
            'PT-1403' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Almeirim
            'PT-1404' => [Holiday::regional('Criação do município', "{$year}-04-02", $this->region)], // Alpiarça
            'PT-1405' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Benavente
            'PT-1406' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Cartaxo
            'PT-1407' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Chamusca
            'PT-1408' => [Holiday::regional('Nossa Senhora da Boa Viagem', $this->getEasterBasedDate($year, 1), $this->region)], // Constância
            'PT-1409' => [Holiday::regional('Dia do Campino do Sorraia', "{$year}-08-17", $this->region)], // Coruche
            'PT-1410' => [Holiday::regional('Criação do município', "{$year}-11-24", $this->region)], // Entroncamento
            'PT-1411' => [$this->getSantoAntonioHoliday($year)], // Ferreira do Zêzere
            'PT-1412' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Golegã
            'PT-1413' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Mação
            'PT-1414' => [Holiday::regional('Criação do município', "{$year}-11-06", $this->region)], // Rio Maior
            'PT-1415' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Salvaterra de Magos
            'PT-1416' => [$this->getSaoJoseHoliday($year)], // Santarém
            'PT-1417' => [Holiday::regional('Elevação à categoria de vila', "{$year}-09-22", $this->region)], // Sardoal
            'PT-1418' => [Holiday::regional('Fundação do Castelo Templário', "{$year}-03-01", $this->region)], // Tomar
            'PT-1419' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Torres Novas
            'PT-1420' => [$this->getSantoAntonioHoliday($year)], // Vila Nova da Barquinha
            'PT-1421' => [Holiday::regional('Elevação a cidade', "{$year}-06-20", $this->region)], // Ourém
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getSetubalRegions(): array
    {
        return [
            'PT-1501', 'PT-1502', 'PT-1503', 'PT-1504', 'PT-1505', 'PT-1506', 'PT-1507', 'PT-1508',
            'PT-1509', 'PT-1510', 'PT-1511', 'PT-1512', 'PT-1513',
        ];
    }

    /** @return array<Holiday> */
    protected function getSetubalHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1501' => [$this->getSaoJoaoHoliday($year)], // Alcácer do Sal
            'PT-1502' => [$this->getSaoJoaoHoliday($year)], // Alcochete
            'PT-1503' => [$this->getSaoJoaoHoliday($year)], // Almada
            'PT-1504' => [Holiday::regional('Elevação a cidade', "{$year}-06-28", $this->region)], // Barreiro
            'PT-1505' => [Holiday::regional('Criação do município através do foral', "{$year}-10-22", $this->region)], // Grândola
            'PT-1506' => [Holiday::regional('Festas em Honra de Nossa Senhora da Boa Viagem', CarbonImmutable::parse("second sunday of september {$year}")->addDays(2), $this->region)], // Moita
            'PT-1507' => [$this->getSaoPedroHoliday($year)], // Montijo
            'PT-1508' => [Holiday::regional('Atribuição do Foral Manuelino', "{$year}-06-01", $this->region)], // Palmela
            'PT-1509' => [$this->getSaoTiagoHoliday($year)], // Santiago do Cacém
            'PT-1510' => [$this->getSaoPedroHoliday($year)], // Seixal
            'PT-1511' => [Holiday::regional('Nosso Senhor Jesus das Chagas', "{$year}-05-04", $this->region)], // Sesimbra
            'PT-1512' => [Holiday::regional('Nascimento de Bocage', "{$year}-09-15", $this->region)], // Setúbal
            'PT-1513' => [Holiday::regional('Elevação a vila', "{$year}-11-24", $this->region)], // Sines
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getVianaDoCasteloRegions(): array
    {
        return [
            'PT-1601', 'PT-1602', 'PT-1603', 'PT-1604', 'PT-1605', 'PT-1606', 'PT-1607', 'PT-1608',
            'PT-1609', 'PT-1610',
        ];
    }

    /** @return array<Holiday> */
    protected function getVianaDoCasteloHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1601' => [$this->getSaoBentoHoliday($year)], // Arcos de Valdevez
            'PT-1602' => [$this->getSegundaFeiraDePascoaHoliday($year)], // Caminha
            'PT-1603' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Melgaço
            'PT-1604' => [Holiday::regional('Outorgação do Foral', "{$year}-03-12", $this->region)], // Monção
            'PT-1605' => [$this->getSaoLourencoHoliday($year)], // Paredes de Coura
            'PT-1606' => [$this->getSaoBartolomeuHoliday($year)], // Ponte da Barca
            'PT-1607' => [Holiday::regional('Outorgação do Foral a vila por D. Teresa', "{$year}-03-04", $this->region)], // Ponte de Lima
            'PT-1608' => [Holiday::regional('São Teotónio', "{$year}-02-18", $this->region)], // Valença
            'PT-1609' => [Holiday::regional('Nossa Senhora da Agonia', "{$year}-08-20", $this->region)], // Viana do Castelo
            'PT-1610' => [Holiday::regional('Dia do Município, dos Bombeiros Voluntários e da Proteção Civil', "{$year}-10-01", $this->region)], // Vila Nova de Cerveira
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getVilaRealRegions(): array
    {
        return [
            'PT-1701', 'PT-1702', 'PT-1703', 'PT-1704', 'PT-1705', 'PT-1706', 'PT-1707', 'PT-1708',
            'PT-1709', 'PT-1710', 'PT-1711', 'PT-1712', 'PT-1713', 'PT-1714',
        ];
    }

    /** @return array<Holiday> */
    protected function getVilaRealHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1701' => [$this->getSaoMartinhoHoliday($year)], // Alijó
            'PT-1702' => [Holiday::regional('Criação do município', "{$year}-11-06", $this->region)], // Boticas
            'PT-1703' => [Holiday::regional('Batalha de Chaves', "{$year}-07-08", $this->region)], // Chaves
            'PT-1704' => [Holiday::regional('Santo André', "{$year}-11-30", $this->region)], // Mesão Frio
            'PT-1705' => [$this->getSaoTiagoHoliday($year)], // Mondim de Basto
            'PT-1706' => [Holiday::regional('Atribuição do foral', "{$year}-06-09", $this->region)], // Montalegre
            'PT-1707' => [Holiday::regional('Fundação do município', "{$year}-05-08", $this->region)], // Murça
            'PT-1708' => [$this->getNossaSenhoraDoSocorroHoliday($year)], // Peso da Régua
            'PT-1709' => [$this->getNossaSenhoraDoSocorroHoliday($year)], // Ribeira de Pena
            'PT-1710' => [Holiday::regional('Nossa Senhora do Rosário', "{$year}-09-08", $this->region)], // Sabrosa
            'PT-1711' => [Holiday::regional('Santa Marta', "{$year}-07-29", $this->region)], // Santa Marta de Penaguião
            'PT-1712' => [Holiday::regional('Criação do município', "{$year}-11-06", $this->region)], // Valpaços
            'PT-1713' => [Holiday::regional('Atribuição do Foral Manuelino', "{$year}-05-16", $this->region)], // Vila Pouca de Aguiar
            'PT-1714' => [$this->getSantoAntonioHoliday($year)], // Vila Real
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getViseuRegions(): array
    {
        return [
            'PT-1801', 'PT-1802', 'PT-1803', 'PT-1804', 'PT-1805', 'PT-1806', 'PT-1807', 'PT-1808',
            'PT-1809', 'PT-1810', 'PT-1811', 'PT-1812', 'PT-1813', 'PT-1814', 'PT-1815', 'PT-1816',
            'PT-1817', 'PT-1818', 'PT-1819', 'PT-1820', 'PT-1821', 'PT-1822', 'PT-1823', 'PT-1824',
        ];
    }

    /** @return array<Holiday> */
    protected function getViseuHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-1801' => [$this->getSaoJoaoHoliday($year)], // Armamar
            'PT-1802' => [Holiday::regional('Nossa Senhora das Febres', CarbonImmutable::parse("third sunday of july {$year}")->addDay(), $this->region)], // Carregal do Sal
            'PT-1803' => [$this->getSaoPedroHoliday($year)], // Castro Daire
            'PT-1804' => [$this->getSaoJoaoHoliday($year)], // Cinfães
            'PT-1805' => [Holiday::regional('Nossa Senhora dos Remédios', "{$year}-09-08", $this->region)], // Lamego
            'PT-1806' => [Holiday::regional('Nossa Senhora do Castelo', "{$year}-09-08", $this->region)], // Mangualde
            'PT-1807' => [$this->getSaoJoaoHoliday($year)], // Moimenta da Beira
            'PT-1808' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Mortágua
            'PT-1809' => [$this->getSaoJoaoHoliday($year)], // Nelas
            'PT-1810' => [Holiday::regional('Restauração do município', "{$year}-10-07", $this->region)], // Oliveira de Frades
            'PT-1811' => [Holiday::regional('São Genésio', "{$year}-08-25", $this->region)], // Penalva do Castelo
            'PT-1812' => [$this->getSaoPedroHoliday($year)], // Penedono
            'PT-1813' => [$this->getSaoMiguelArcanjoHoliday($year)], // Resende
            'PT-1814' => [$this->getQuintaFeiraDaAscensaoHoliday($year)], // Santa Comba Dão
            'PT-1815' => [$this->getSaoJoaoHoliday($year)], // São João da Pesqueira
            'PT-1816' => [$this->getSaoPedroHoliday($year)], // São Pedro do Sul
            'PT-1817' => [$this->getSaoBernardoHoliday($year)], // Sátão
            'PT-1818' => [Holiday::regional('Festa de Nossa Senhora ao Pé da Cruz', "{$year}-05-03", $this->region)], // Sernancelhe
            'PT-1819' => [$this->getSaoJoaoHoliday($year)], // Tabuaço
            'PT-1820' => [$this->getSaoMiguelArcanjoHoliday($year)], // Tarouca
            'PT-1821' => [Holiday::regional('Santa Eufémia', "{$year}-09-16", $this->region)], // Tondela
            'PT-1822' => [Holiday::regional('Estabelecimento e denominação da sede de concelho', "{$year}-03-02", $this->region)], // Vila Nova de Paiva
            'PT-1823' => [$this->getSaoMateusHoliday($year)], // Viseu
            'PT-1824' => [Holiday::regional('São Frei Gil', "{$year}-05-14", $this->region)], // Vouzela
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getMadeiraRegions(): array
    {
        return [
            'PT-3101', 'PT-3102', 'PT-3103', 'PT-3104', 'PT-3105', 'PT-3106', 'PT-3107', 'PT-3108',
            'PT-3109', 'PT-3110', 'PT-3201',
        ];
    }

    /** @return array<Holiday> */
    protected function getMadeiraHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-3101' => [$this->getSaoJoaoHoliday($year)], // Calheta
            'PT-3102' => [Holiday::regional('Criação do município', "{$year}-10-04", $this->region)], // Câmara de Lobos
            'PT-3103' => [Holiday::regional('Dia da Cidade do Funchal', "{$year}-08-21", $this->region)], // Funchal
            'PT-3104' => [Holiday::regional('Criação da Capitania de Machico', "{$year}-05-08", $this->region)], // Machico
            'PT-3105' => [$this->getNossaSenhoraDaLuzHoliday($year)], // Ponta do Sol
            'PT-3106' => [$this->getSantaMariaMadalenaHoliday($year)], // Porto Moniz
            'PT-3107' => [$this->getSaoPedroHoliday($year)], // Ribeira Brava
            'PT-3108' => [Holiday::regional('Santo Amaro', "{$year}-01-15", $this->region)], // Santa Cruz
            'PT-3109' => [Holiday::regional('Fundação do município', "{$year}-05-25", $this->region)], // Santana
            'PT-3110' => [$this->getSaoVicenteHoliday($year)], // São Vicente
            'PT-3201' => [Holiday::regional('Criação do município', "{$year}-06-24", $this->region)], // Porto Santo
            default => [],
        };
    }

    /** @return array<string> */
    protected static function getAcoresRegions(): array
    {
        return [
            'PT-4101', 'PT-4201', 'PT-4202', 'PT-4203', 'PT-4204', 'PT-4205', 'PT-4206', 'PT-4301',
            'PT-4302', 'PT-4401', 'PT-4501', 'PT-4502', 'PT-4601', 'PT-4602', 'PT-4603', 'PT-4701',
            'PT-4801', 'PT-4802', 'PT-4901',
        ];
    }

    /** @return array<Holiday> */
    protected function getAcoresHolidays(int $year): array
    {
        return match ($this->region) {
            'PT-4101' => [$this->getSaoJoaoHoliday($year)], // Vila do Porto
            'PT-4201' => [Holiday::regional('Criação do município', "{$year}-04-11", $this->region)], // Lagoa
            'PT-4202' => [Holiday::regional('Fundação do município', "{$year}-07-18", $this->region)], // Nordeste
            'PT-4203' => [Holiday::regional('Senhor Santo Cristo dos Milagres', $this->getEasterBasedDate($year, 36), $this->region)], // Ponta Delgada
            'PT-4204' => [Holiday::regional('Oitava do Corpo de Deus', $this->getEasterBasedDate($year, 61), $this->region)], // Povoação
            'PT-4205' => [$this->getSaoPedroHoliday($year)], // Ribeira Grande
            'PT-4206' => [$this->getSaoJoaoHoliday($year)], // Vila Franca do Campo
            'PT-4301' => [$this->getSaoJoaoHoliday($year)], // Angra do Heroísmo
            'PT-4302' => [Holiday::regional('Batalha da Praia', "{$year}-08-11", $this->region)], // Praia da Vitória
            'PT-4401' => [Holiday::regional('Senhor Santo Cristo dos Milagres', CarbonImmutable::parse("second sunday of august {$year}")->addDay(), $this->region)], // Santa Cruz da Graciosa
            'PT-4501' => [Holiday::regional('Santa Catarina de Alexandria', "{$year}-11-25", $this->region)], // Calheta
            'PT-4502' => [Holiday::regional('São Jorge', "{$year}-04-23", $this->region)], // Velas
            'PT-4601' => [$this->getSaoPedroHoliday($year)], // Lajes do Pico
            'PT-4602' => [$this->getSantaMariaMadalenaHoliday($year)], // Madalena
            'PT-4603' => [Holiday::regional('São Roque', "{$year}-08-16", $this->region)], // São Roque do Pico
            'PT-4701' => [$this->getSaoJoaoHoliday($year)], // Horta
            'PT-4801' => [Holiday::regional('Nossa Senhora do Rosário', CarbonImmutable::parse("third sunday of july {$year}")->addDay(), $this->region)], // Lajes das Flores
            'PT-4802' => [$this->getSaoJoaoHoliday($year)], // Santa Cruz das Flores
            'PT-4901' => [Holiday::regional('Elevação a vila e sede de concelho', "{$year}-06-20", $this->region)], // Corvo
            default => [],
        };
    }
}
