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
        $method = "regionHolidays{$year}";
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            return [];
        }
    }

    /** @return array<string, string> */
    protected function regionHolidays2022(): array
    {
        $april14th = ['Jueves Santo' => '04-14'];
        $april18th = ['Lunes de Pascua' => '04-18'];
        $may2nd = ['Lunes siguiente a la Fiesta del Trabajo' => '05-02'];
        $june24th = ['San Juan' => '06-24'];
        $july25th = ['Santiago Apóstol' => '07-25'];
        $december26th = ['Lunes siguiente a Navidad' => '12-26'];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => '02-28',
            ] + $april14th + $may2nd + $december26th,

            // Aragón
            'es-ar' => [
                'Lunes siguiente a San Jorge, Día de Aragón' => '04-23',
            ] + $april14th + $may2nd + $december26th,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => '09-08',
            ] + $april14th + $may2nd + $december26th,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => '07-28',
                'La Bien Aparecida' => '09-15',
            ] + $april14th + $december26th,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Fiesta del Sacrificio Eid al-Adha' => '07-09',
                'Nuestra Señora de África' => '08-05',
                'Día de Ceuta' => '09-02',
            ] + $april14th,

            // Castilla y León
            'es-cl' => [
                'Día de Castilla y León' => '04-23',
            ] + $april14th + $may2nd + $december26th,

            // Castilla-La Mancha
            'es-cm' => [
                'Día de Castilla-La Mancha' => '05-31',
                'Corpus Christi' => '06-16',
            ] + $april14th + $december26th,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => '05-30',
            ] + $april14th + $december26th,

            // Cataluña / Catalunya
            'es-ct' => [
                'Pascua Granada' => '06-06',
            ] + $april18th + $june24th + $december26th,

            // Extremadura
            'es-ex' => [
                'Día de Extremadura' => '09-08',
            ] + $april14th + $may2nd + $december26th,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => '05-17',
                'Santiago Apóstol / Día de Galicia' => '07-25',
            ] + $april14th + $june24th,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => '03-01',
            ] + $april14th + $april18th + $december26th,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => '06-09',
            ] + $april14th + $may2nd + $december26th,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => '05-02',
            ] + $april14th + $july25th + $december26th,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Fiesta del Eid al-Fitr' => '05-03',
                'Fiesta del Sacrificio Eid al-Adha' => '07-11'
            ] + $april14th + $december26th,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $april14th + $april18th + $july25th + $december26th,

            // País Vasco / Euskal Herria
            'es-pv' => [
                'V Centenario de la Primera Vuelta al Mundo' => '09-06',
            ] + $april14th + $april18th + $july25th,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => '06-09',
            ] + $april14th + $april18th + $december26th,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => '10-09',
                'San José' => '03-19',
            ] + $april14th + $april18th + $june24th,

            default => [],
        };
    }

    /** @return array<string, string> */
    protected function regionHolidays2023(): array
    {
        $january2nd = ['Lunes siguiente a la Fiesta de Año Nuevo' => '01-02'];
        $april6th = ['Jueves Santo' => '04-06'];
        $april10th = ['Lunes de Pascua' => '04-10'];
        $june24th = ['San Juan' => '06-24'];
        $june29th = ['Fiesta del Sacrificio Eid al-Adha' => '06-29'];
        $july25th = ['Santiago Apóstol' => '07-25'];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => '02-28',
            ] + $january2nd + $april6th,

            // Aragón
            'es-ar' => [
                'Lunes siguiente a San Jorge, Día de Aragón' => '04-24',
            ] + $january2nd + $april6th,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => '09-08',
            ] + $january2nd + $april6th,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => '07-28',
                'La Bien Aparecida' => '09-15',
            ] + $april6th,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => '08-05',
                'Día de Ceuta' => '09-02',
            ] + $april6th + $june29th,

            // Castilla y León
            'es-cl' => $january2nd + $april6th + $july25th,

            // Castilla-La Mancha
            'es-cm' => [
                'Día de Castilla-La Mancha' => '05-31',
                'Corpus Christi' => '06-08',
            ] + $april6th,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => '05-30',
            ] + $april6th,

            // Cataluña / Catalunya
            'es-ct' => [
                'Fiesta Nacional de Cataluña' => '09-11',
                'San Esteban' => '12-26',
            ] + $april10th + $june24th,

            // Extremadura
            'es-ex' => [
                'Carnaval' => '02-13',
                'Día de Extremadura' => '09-08',
            ] + $april6th,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => '05-17',
                'Santiago Apóstol / Día de Galicia' => '07-25',
            ] + $april6th,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => '03-01',
            ] + $april10th,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => '06-09',
            ] + $january2nd + $april6th,

            // Comunidad de Madrid
            'es-md' => [
                'Lunes siguiente A San José' => '03-20',
                'Fiesta de la Comunidad de Madrid' => '05-02',
            ] + $april6th,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Fiesta del Eid al-Fitr' => '04-21',
            ] + $april6th + $june29th,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $april6th + $april10th + $july25th,

            // País Vasco / Euskal Herria
            'es-pv' => $april6th + $april10th + $july25th,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => '06-09',
            ] + $april6th + $april10th,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => '10-09',
            ] + $april10th + $june24th,

            default => [],
        };
    }

    /** @return array<string, string> */
    protected function regionHolidays2024(): array
    {
        $march19th = ['San José' => '03-19'];
        $march28th = ['Jueves Santo' => '03-28'];
        $april1st = ['Lunes de Pascua' => '04-01'];
        $june17th = ['Fiesta del Sacrificio Eid al-Adha' => '06-17'];
        $june24th = ['San Juan' => '06-24'];
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

            // Ciudad Autónoma de Ceuta
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
                'Fiesta Nacional de Cataluña' => '09-11',
                'San Esteban' => '12-26',
            ] + $april1st + $june24th,

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

            // Ciudad Autónoma de Melilla
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
                'Día de la Comunidad Valenciana' => '10-09',
            ] + $march19th + $april1st + $june24th,

            default => [],
        };
    }
}
