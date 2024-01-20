<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Spain extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    public function countryCode(): string
    {
        return 'es';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            [
                'Año Nuevo' => '01-01',
                'Epifanía del Señor' => '01-06',
                'Día del Trabajador' => '05-01',
                'Asunción de la Virgen' => '08-15',
                'Fiesta Nacional de España' => '10-12',
                'Todos los Santos' => '11-01',
                'Día de la Constitución Española' => '12-06',
                'Inmaculada Concepción' => '12-08', // 2024?
                'Navidad' => '12-25'
            ],
            $this->variableHolidays($year),
            $this->regionHolidays($year),
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Viernes Santo' => $easter->subDays(2),
        ];
    }

    /** @return array<string, string> */
    protected function regionHolidays(int $year): array
    {
        if ($year === 2024) {
            return $this->regionHolidays2024();
        }

        return [];
    }

    /** @return array<string, string> */
    protected function regionHolidays2024(): array
    {
        $march19th = ['San José' => '03-19'];
        $march28th = ['Jueves Santo' => '03-28'];
        $april1st = ['Lunes de Pascua' => '04-01'];
        $june17th = ['Fiesta del Sacrificio Eid al-Adha' => '06-17'];
        $july25th = ['Santiago Apóstol' => '07-25'];
        $december9th = ['Lunes siguiente a la Inmaculada Concepción' => '12-09'];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => '02-28',
            ] + $march28th + $december9th,

            // Aragón
            'es-ar' => [
                'San Jorge / Día de Aragón' => '04-23',
            ] + $march28th + $december9th,

            // Principado de Asturias
            'es-as' => [
                'Lunes siguiente al Día de Asturias' => '09-09',
            ] + $march28th + $december9th,

            // Cantabria
            'es-cb' => $march28th + $april1st + $july25th,

            // Ceuta [autonomous city]
            'es-ce' => [
                'Nuestra Señora de África' => '08-05',
            ] + $march28th + $june17th,

            // Castilla y León
            'es-cl' => [
                'Fiesta de Castilla y León' => '04-23',
            ] + $march28th + $december9th,

            // Castilla-La Mancha
            'es-cm' => [
                'Corpus Christi' => '05-30',
                'Día de Castilla-La Mancha' => '05-31',
            ] + $march28th,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => '05-30',
            ] + $march28th,

            // Cataluña / Catalunya
            'es-ct' => [
                'San Juan' => '06-24',
                'Fiesta Nacional de Cataluña' => '09-11',
                'San Esteban' => '12-26',
            ] + $april1st,

            // Extremadura
            'es-ex' => [
                'Carnaval' => '02-13',
            ] + $march28th + $december9th,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => '05-17',
                'Santiago Apóstol / Día de Galicia' => '07-25',
            ] + $march28th,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => '03-01',
            ] + $march28th + $april1st,

            // Región de Murcia
            'es-mc' => $march19th + $march28th + $december9th,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => '05-02',
            ] + $march28th + $july25th,

            // Melilla [autonomous city]
            'es-ml' => $march28th + $june17th + $december9th,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $march28th + $april1st + $july25th,

            // País Vasco / Euskal Herria
            'es-pv' => $march28th + $april1st + $july25th,

            // La Rioja
            'es-ri' => [
                'Lunes siguiente al Día de La Rioja' => '06-10',
            ] + $march28th + $april1st,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'San Juan' => '06-24',
                'Día de la Comunidad Valenciana' => '10-09',
            ] + $march19th + $april1st,

            default => [],
        };
    }
}
