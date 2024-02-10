<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Exceptions\InvalidYear;

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
                'Navidad' => '12-25',
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
        if ($this->region === null) {
            return [];
        }

        $method = "regionHolidays{$year}";
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        throw InvalidYear::range($this->countryCode()." ({$this->region})", 2022, 2024);
    }

    /** @return array<string, string> */
    protected function regionHolidays2022(): array
    {
        $juevesSanto = ['Jueves Santo' => '04-14'];
        $lunesPascua = ['Lunes de Pascua' => '04-18'];
        $fiestaTrabajo = ['Lunes siguiente a la Fiesta del Trabajo' => '05-02'];
        $sanJuan = ['San Juan' => '06-24'];
        $santiagoApostol = ['Santiago Apóstol' => '07-25'];
        $navidad = ['Lunes siguiente a Navidad' => '12-26'];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => '02-28',
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Aragón
            'es-ar' => [
                'Lunes siguiente a San Jorge, Día de Aragón' => '04-23',
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => '09-08',
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => '07-28',
                'La Bien Aparecida' => '09-15',
            ] + $juevesSanto + $navidad,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Fiesta del Sacrificio Eid al-Adha' => '07-09',
                'Nuestra Señora de África' => '08-05',
                'Día de Ceuta' => '09-02',
            ] + $juevesSanto,

            // Castilla y León
            'es-cl' => [
                'Día de Castilla y León' => '04-23',
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Castilla-La Mancha
            'es-cm' => [
                'Día de Castilla-La Mancha' => '05-31',
                'Corpus Christi' => '06-16',
            ] + $juevesSanto + $navidad,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => '05-30',
            ] + $juevesSanto + $navidad,

            // Cataluña / Catalunya
            'es-ct' => [
                'Pascua Granada' => '06-06',
            ] + $lunesPascua + $sanJuan + $navidad,

            // Extremadura
            'es-ex' => [
                'Día de Extremadura' => '09-08',
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => '05-17',
                'Santiago Apóstol / Día de Galicia' => '07-25',
            ] + $juevesSanto + $sanJuan,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => '03-01',
            ] + $juevesSanto + $lunesPascua + $navidad,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => '06-09',
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => '05-02',
            ] + $juevesSanto + $santiagoApostol + $navidad,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Fiesta del Eid al-Fitr' => '05-03',
                'Fiesta del Sacrificio Eid al-Adha' => '07-11',
            ] + $juevesSanto + $navidad,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $juevesSanto + $lunesPascua + $santiagoApostol + $navidad,

            // País Vasco / Euskal Herria
            'es-pv' => [
                'V Centenario de la Primera Vuelta al Mundo' => '09-06',
            ] + $juevesSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => '06-09',
            ] + $juevesSanto + $lunesPascua + $navidad,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => '10-09',
                'San José' => '03-19',
            ] + $juevesSanto + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }

    /** @return array<string, string> */
    protected function regionHolidays2023(): array
    {
        $anoNuevo = ['Lunes siguiente a la Fiesta de Año Nuevo' => '01-02'];
        $jueveSanto = ['Jueves Santo' => '04-06'];
        $lunesPascua = ['Lunes de Pascua' => '04-10'];
        $sanJuan = ['San Juan' => '06-24'];
        $fiestaSacrificio = ['Fiesta del Sacrificio Eid al-Adha' => '06-29'];
        $santiagoApostol = ['Santiago Apóstol' => '07-25'];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => '02-28',
            ] + $anoNuevo + $jueveSanto,

            // Aragón
            'es-ar' => [
                'Lunes siguiente a San Jorge, Día de Aragón' => '04-24',
            ] + $anoNuevo + $jueveSanto,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => '09-08',
            ] + $anoNuevo + $jueveSanto,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => '07-28',
                'La Bien Aparecida' => '09-15',
            ] + $jueveSanto,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => '08-05',
                'Día de Ceuta' => '09-02',
            ] + $jueveSanto + $fiestaSacrificio,

            // Castilla y León
            'es-cl' => $anoNuevo + $jueveSanto + $santiagoApostol,

            // Castilla-La Mancha
            'es-cm' => [
                'Día de Castilla-La Mancha' => '05-31',
                'Corpus Christi' => '06-08',
            ] + $jueveSanto,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => '05-30',
            ] + $jueveSanto,

            // Cataluña / Catalunya
            'es-ct' => [
                'Fiesta Nacional de Cataluña' => '09-11',
                'San Esteban' => '12-26',
            ] + $lunesPascua + $sanJuan,

            // Extremadura
            'es-ex' => [
                'Carnaval' => '02-13',
                'Día de Extremadura' => '09-08',
            ] + $jueveSanto,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => '05-17',
                'Santiago Apóstol / Día de Galicia' => '07-25',
            ] + $jueveSanto,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => '03-01',
            ] + $lunesPascua,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => '06-09',
            ] + $anoNuevo + $jueveSanto,

            // Comunidad de Madrid
            'es-md' => [
                'Lunes siguiente A San José' => '03-20',
                'Fiesta de la Comunidad de Madrid' => '05-02',
            ] + $jueveSanto,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Fiesta del Eid al-Fitr' => '04-21',
            ] + $jueveSanto + $fiestaSacrificio,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $jueveSanto + $lunesPascua + $santiagoApostol,

            // País Vasco / Euskal Herria
            'es-pv' => $jueveSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => '06-09',
            ] + $jueveSanto + $lunesPascua,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => '10-09',
            ] + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }

    /** @return array<string, string> */
    protected function regionHolidays2024(): array
    {
        $sanJose = ['San José' => '03-19'];
        $juevesSanto = ['Jueves Santo' => '03-28'];
        $lunesPascua = ['Lunes de Pascua' => '04-01'];
        $fiestaSacrificio = ['Fiesta del Sacrificio Eid al-Adha' => '06-17'];
        $sanJuan = ['San Juan' => '06-24'];
        $santiagoApostol = ['Santiago Apóstol' => '07-25'];
        $inmaculadaConcepcion = ['Lunes siguiente a la Inmaculada Concepción' => '12-09'];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => '02-28',
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Aragón
            'es-ar' => [
                'San Jorge / Día de Aragón' => '04-23',
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Principado de Asturias
            'es-as' => [
                'Lunes siguiente al Día de Asturias' => '09-09',
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Cantabria
            'es-cb' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => '08-05',
            ] + $juevesSanto + $fiestaSacrificio,

            // Castilla y León
            'es-cl' => [
                'Fiesta de Castilla y León' => '04-23',
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Castilla-La Mancha
            'es-cm' => [
                'Corpus Christi' => '05-30',
                'Día de Castilla-La Mancha' => '05-31',
            ] + $juevesSanto,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => '05-30',
            ] + $juevesSanto,

            // Cataluña / Catalunya
            'es-ct' => [
                'Fiesta Nacional de Cataluña' => '09-11',
                'San Esteban' => '12-26',
            ] + $lunesPascua + $sanJuan,

            // Extremadura
            'es-ex' => [
                'Carnaval' => '02-13',
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => '05-17',
                'Santiago Apóstol / Día de Galicia' => '07-25',
            ] + $juevesSanto,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => '03-01',
            ] + $juevesSanto + $lunesPascua,

            // Región de Murcia
            'es-mc' => $sanJose + $juevesSanto + $inmaculadaConcepcion,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => '05-02',
            ] + $juevesSanto + $santiagoApostol,

            // Ciudad Autónoma de Melilla
            'es-ml' => $juevesSanto + $fiestaSacrificio + $inmaculadaConcepcion,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // País Vasco / Euskal Herria
            'es-pv' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Lunes siguiente al Día de La Rioja' => '06-10',
            ] + $juevesSanto + $lunesPascua,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => '10-09',
            ] + $sanJose + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }
}
