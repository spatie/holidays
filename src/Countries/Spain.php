<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Exceptions\InvalidYear;

class Spain extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {}

    public function countryCode(): string
    {
        return 'es';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge(
            [
                'Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 1),
                'Epifanía del Señor' => CarbonImmutable::createFromDate($year, 1, 6),
                'Día del Trabajador' => CarbonImmutable::createFromDate($year, 5, 1),
                'Asunción de la Virgen' => CarbonImmutable::createFromDate($year, 8, 15),
                'Fiesta Nacional de España' => CarbonImmutable::createFromDate($year, 10, 12),
                'Todos los Santos' => CarbonImmutable::createFromDate($year, 11, 1),
                'Día de la Constitución Española' => CarbonImmutable::createFromDate($year, 12, 6),
                'Inmaculada Concepción' => CarbonImmutable::createFromDate($year, 12, 8), // 2024?
                'Navidad' => CarbonImmutable::createFromDate($year, 12, 25),
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

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays(int $year): array
    {
        if ($this->region === null) {
            return [];
        }

        $method = "regionHolidays{$year}";
        if (method_exists($this, $method)) {
            return $this->$method($year);
        }

        throw InvalidYear::range($this->countryCode()." ({$this->region})", 2022, 2025);
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays2022(int $year): array
    {
        $juevesSanto = ['Jueves Santo' => CarbonImmutable::createFromDate($year, 4, 14)];
        $lunesPascua = ['Lunes de Pascua' => CarbonImmutable::createFromDate($year, 4, 18)];
        $fiestaTrabajo = ['Lunes siguiente a la Fiesta del Trabajo' => CarbonImmutable::createFromDate($year, 5, 2)];
        $sanJuan = ['San Juan' => CarbonImmutable::createFromDate($year, 6, 24)];
        $santiagoApostol = ['Santiago Apóstol' => CarbonImmutable::createFromDate($year, 7, 25)];
        $navidad = ['Lunes siguiente a Navidad' => CarbonImmutable::createFromDate($year, 12, 26)];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => CarbonImmutable::createFromDate($year, 2, 28),
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Aragón
            'es-ar' => [
                'Lunes siguiente a San Jorge, Día de Aragón' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => CarbonImmutable::createFromDate($year, 7, 28),
                'La Bien Aparecida' => CarbonImmutable::createFromDate($year, 9, 15),
            ] + $juevesSanto + $navidad,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Fiesta del Sacrificio Eid al-Adha' => CarbonImmutable::createFromDate($year, 7, 9),
                'Nuestra Señora de África' => CarbonImmutable::createFromDate($year, 8, 5),
                'Día de Ceuta' => CarbonImmutable::createFromDate($year, 9, 2),
            ] + $juevesSanto,

            // Castilla y León
            'es-cl' => [
                'Día de Castilla y León' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Castilla-La Mancha
            'es-cm' => [
                'Día de Castilla-La Mancha' => CarbonImmutable::createFromDate($year, 5, 31),
                'Corpus Christi' => CarbonImmutable::createFromDate($year, 6, 16),
            ] + $juevesSanto + $navidad,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => CarbonImmutable::createFromDate($year, 5, 30),
            ] + $juevesSanto + $navidad,

            // Cataluña / Catalunya
            'es-ct' => [
                'Pascua Granada' => CarbonImmutable::createFromDate($year, 6, 6),
            ] + $lunesPascua + $sanJuan + $navidad,

            // Extremadura
            'es-ex' => [
                'Día de Extremadura' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => CarbonImmutable::createFromDate($year, 5, 17),
                'Santiago Apóstol / Día de Galicia' => CarbonImmutable::createFromDate($year, 7, 25),
            ] + $juevesSanto + $sanJuan,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => CarbonImmutable::createFromDate($year, 3, 1),
            ] + $juevesSanto + $lunesPascua + $navidad,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $juevesSanto + $fiestaTrabajo + $navidad,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => CarbonImmutable::createFromDate($year, 5, 2),
            ] + $juevesSanto + $santiagoApostol + $navidad,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Fiesta del Eid al-Fitr' => CarbonImmutable::createFromDate($year, 5, 3),
                'Fiesta del Sacrificio Eid al-Adha' => CarbonImmutable::createFromDate($year, 7, 11),
            ] + $juevesSanto + $navidad,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $juevesSanto + $lunesPascua + $santiagoApostol + $navidad,

            // País Vasco / Euskal Herria
            'es-pv' => [
                'V Centenario de la Primera Vuelta al Mundo' => CarbonImmutable::createFromDate($year, 9, 6),
            ] + $juevesSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $juevesSanto + $lunesPascua + $navidad,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => CarbonImmutable::createFromDate($year, 10, 9),
                'San José' => CarbonImmutable::createFromDate($year, 3, 19),
            ] + $juevesSanto + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays2023(int $year): array
    {
        $anoNuevo = ['Lunes siguiente a la Fiesta de Año Nuevo' => CarbonImmutable::createFromDate($year, 1, 2)];
        $jueveSanto = ['Jueves Santo' => CarbonImmutable::createFromDate($year, 4, 6)];
        $lunesPascua = ['Lunes de Pascua' => CarbonImmutable::createFromDate($year, 4, 10)];
        $sanJuan = ['San Juan' => CarbonImmutable::createFromDate($year, 6, 24)];
        $fiestaSacrificio = ['Fiesta del Sacrificio Eid al-Adha' => CarbonImmutable::createFromDate($year, 6, 29)];
        $santiagoApostol = ['Santiago Apóstol' => CarbonImmutable::createFromDate($year, 7, 25)];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => CarbonImmutable::createFromDate($year, 2, 28),
            ] + $anoNuevo + $jueveSanto,

            // Aragón
            'es-ar' => [
                'Lunes siguiente a San Jorge, Día de Aragón' => CarbonImmutable::createFromDate($year, 4, 24),
            ] + $anoNuevo + $jueveSanto,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $anoNuevo + $jueveSanto,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => CarbonImmutable::createFromDate($year, 7, 28),
                'La Bien Aparecida' => CarbonImmutable::createFromDate($year, 9, 15),
            ] + $jueveSanto,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => CarbonImmutable::createFromDate($year, 8, 5),
                'Día de Ceuta' => CarbonImmutable::createFromDate($year, 9, 2),
            ] + $jueveSanto + $fiestaSacrificio,

            // Castilla y León
            'es-cl' => $anoNuevo + $jueveSanto + $santiagoApostol,

            // Castilla-La Mancha
            'es-cm' => [
                'Día de Castilla-La Mancha' => CarbonImmutable::createFromDate($year, 5, 31),
                'Corpus Christi' => CarbonImmutable::createFromDate($year, 6, 8),
            ] + $jueveSanto,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => CarbonImmutable::createFromDate($year, 5, 30),
            ] + $jueveSanto,

            // Cataluña / Catalunya
            'es-ct' => [
                'Fiesta Nacional de Cataluña' => CarbonImmutable::createFromDate($year, 9, 11),
                'San Esteban' => CarbonImmutable::createFromDate($year, 12, 26),
            ] + $lunesPascua + $sanJuan,

            // Extremadura
            'es-ex' => [
                'Carnaval' => CarbonImmutable::createFromDate($year, 2, 13),
                'Día de Extremadura' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $jueveSanto,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => CarbonImmutable::createFromDate($year, 5, 17),
                'Santiago Apóstol / Día de Galicia' => CarbonImmutable::createFromDate($year, 7, 25),
            ] + $jueveSanto,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => CarbonImmutable::createFromDate($year, 3, 1),
            ] + $lunesPascua,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $anoNuevo + $jueveSanto,

            // Comunidad de Madrid
            'es-md' => [
                'Lunes siguiente A San José' => CarbonImmutable::createFromDate($year, 3, 20),
                'Fiesta de la Comunidad de Madrid' => CarbonImmutable::createFromDate($year, 5, 2),
            ] + $jueveSanto,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Fiesta del Eid al-Fitr' => CarbonImmutable::createFromDate($year, 4, 21),
            ] + $jueveSanto + $fiestaSacrificio,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $jueveSanto + $lunesPascua + $santiagoApostol,

            // País Vasco / Euskal Herria
            'es-pv' => $jueveSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $jueveSanto + $lunesPascua,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => CarbonImmutable::createFromDate($year, 10, 9),
            ] + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays2024(int $year): array
    {
        $sanJose = ['San José' => CarbonImmutable::createFromDate($year, 3, 19)];
        $juevesSanto = ['Jueves Santo' => CarbonImmutable::createFromDate($year, 3, 28)];
        $lunesPascua = ['Lunes de Pascua' => CarbonImmutable::createFromDate($year, 4, 1)];
        $fiestaSacrificio = ['Fiesta del Sacrificio Eid al-Adha' => CarbonImmutable::createFromDate($year, 6, 17)];
        $sanJuan = ['San Juan' => CarbonImmutable::createFromDate($year, 6, 24)];
        $santiagoApostol = ['Santiago Apóstol' => CarbonImmutable::createFromDate($year, 7, 25)];
        $inmaculadaConcepcion = ['Lunes siguiente a la Inmaculada Concepción' => CarbonImmutable::createFromDate($year, 12, 9)];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => CarbonImmutable::createFromDate($year, 2, 28),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Aragón
            'es-ar' => [
                'San Jorge / Día de Aragón' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Principado de Asturias
            'es-as' => [
                'Lunes siguiente al Día de Asturias' => CarbonImmutable::createFromDate($year, 9, 9),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Cantabria
            'es-cb' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => CarbonImmutable::createFromDate($year, 8, 5),
            ] + $juevesSanto + $fiestaSacrificio,

            // Castilla y León
            'es-cl' => [
                'Fiesta de Castilla y León' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Castilla-La Mancha
            'es-cm' => [
                'Corpus Christi' => CarbonImmutable::createFromDate($year, 5, 30),
                'Día de Castilla-La Mancha' => CarbonImmutable::createFromDate($year, 5, 31),
            ] + $juevesSanto,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => CarbonImmutable::createFromDate($year, 5, 30),
            ] + $juevesSanto,

            // Cataluña / Catalunya
            'es-ct' => [
                'Fiesta Nacional de Cataluña' => CarbonImmutable::createFromDate($year, 9, 11),
                'San Esteban' => CarbonImmutable::createFromDate($year, 12, 26),
            ] + $lunesPascua + $sanJuan,

            // Extremadura
            'es-ex' => [
                'Carnaval' => CarbonImmutable::createFromDate($year, 2, 13),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => CarbonImmutable::createFromDate($year, 5, 17),
                'Santiago Apóstol / Día de Galicia' => CarbonImmutable::createFromDate($year, 7, 25),
            ] + $juevesSanto,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => CarbonImmutable::createFromDate($year, 3, 1),
            ] + $juevesSanto + $lunesPascua,

            // Región de Murcia
            'es-mc' => $sanJose + $juevesSanto + $inmaculadaConcepcion,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => CarbonImmutable::createFromDate($year, 5, 2),
            ] + $juevesSanto + $santiagoApostol,

            // Ciudad Autónoma de Melilla
            'es-ml' => $juevesSanto + $fiestaSacrificio + $inmaculadaConcepcion,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // País Vasco / Euskal Herria
            'es-pv' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Lunes siguiente al Día de La Rioja' => CarbonImmutable::createFromDate($year, 6, 10),
            ] + $juevesSanto + $lunesPascua,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => CarbonImmutable::createFromDate($year, 10, 9),
            ] + $sanJose + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays2025(int $year): array
    {
        $sanJose = ['San José' => CarbonImmutable::createFromDate($year, 3, 19)];
        $juevesSanto = ['Jueves Santo' => CarbonImmutable::createFromDate($year, 4, 17)];
        $lunesPascua = ['Lunes de Pascua' => CarbonImmutable::createFromDate($year, 4, 21)];
        $fiestaSacrificio = ['Fiesta del Sacrificio Eid al-Adha' => CarbonImmutable::createFromDate($year, 6, 7)];
        $sanJuan = ['San Juan' => CarbonImmutable::createFromDate($year, 6, 24)];
        $santiagoApostol = ['Santiago Apóstol' => CarbonImmutable::createFromDate($year, 7, 25)];
        $inmaculadaConcepcion = ['Lunes siguiente a la Inmaculada Concepción' => CarbonImmutable::createFromDate($year, 12, 8)];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => CarbonImmutable::createFromDate($year, 2, 28),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Aragón
            'es-ar' => [
                'San Jorge / Día de Aragón' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Cantabria
            'es-cb' => $juevesSanto + $lunesPascua + $santiagoApostol,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => CarbonImmutable::createFromDate($year, 8, 5),
            ] + $juevesSanto + $fiestaSacrificio,

            // Castilla y León
            'es-cl' => [
                'Fiesta de Castilla y León' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Castilla-La Mancha
            'es-cm' => [
                'Corpus Christi' => CarbonImmutable::createFromDate($year, 6, 19),
                'Día de Castilla-La Mancha' => CarbonImmutable::createFromDate($year, 5, 31),
            ] + $juevesSanto,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => CarbonImmutable::createFromDate($year, 5, 30),
            ] + $juevesSanto,

            // Cataluña / Catalunya
            'es-ct' => [
                'Fiesta Nacional de Cataluña' => CarbonImmutable::createFromDate($year, 9, 11),
                'San Esteban' => CarbonImmutable::createFromDate($year, 12, 26),
            ] + $lunesPascua + $sanJuan,

            // Extremadura
            'es-ex' => [
                'Día de Extremadura' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $juevesSanto + $inmaculadaConcepcion,

            // Galicia
            'es-ga' => [
                'Día de las Letras Gallegas' => CarbonImmutable::createFromDate($year, 5, 17),
                'Santiago Apóstol / Día de Galicia' => CarbonImmutable::createFromDate($year, 7, 25),
            ] + $juevesSanto,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Día de les Illes Balears' => CarbonImmutable::createFromDate($year, 3, 1),
                'San Esteban' => CarbonImmutable::createFromDate($year, 12, 26),
            ] + $juevesSanto + $lunesPascua,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $sanJose + $juevesSanto + $inmaculadaConcepcion,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => CarbonImmutable::createFromDate($year, 5, 2),
            ] + $juevesSanto + $santiagoApostol,

            // Ciudad Autónoma de Melilla
            'es-ml' => $juevesSanto + $fiestaSacrificio + $inmaculadaConcepcion,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => [
                'Día de Navarra: San Francisco Javier' => CarbonImmutable::createFromDate($year, 12, 3),
            ] + $juevesSanto + $lunesPascua + $santiagoApostol,

            // País Vasco / Euskal Herria
            'es-pv' => [
                'Día del País Vasco / Euskadiko Eguna' => CarbonImmutable::createFromDate($year, 10, 25),
            ] + $juevesSanto + $lunesPascua + $santiagoApostol,

            // La Rioja
            'es-ri' => [
                'Lunes siguiente al Día de La Rioja' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $juevesSanto + $lunesPascua,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunidad Valenciana' => CarbonImmutable::createFromDate($year, 10, 9),
            ] + $sanJose + $lunesPascua + $sanJuan,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays2026(int $year): array
    {
        $sanJose = ['San José' => CarbonImmutable::createFromDate($year, 3, 19)];
        $juevesSanto = ['Jueves Santo' => CarbonImmutable::createFromDate($year, 4, 2)];
        $lunesPascua = ['Lunes de Pascua' => CarbonImmutable::createFromDate($year, 4, 6)];
        $eidAlAdha = ['Eid al-Adha (Fiesta del Sacrificio)' => CarbonImmutable::createFromDate($year, 5, 27)];
        $sanJuan = ['San Juan' => CarbonImmutable::createFromDate($year, 6, 24)];
        $santiagoApostol = ['Santiago Apóstol' => CarbonImmutable::createFromDate($year, 7, 25)];
        $trasladoTodosLosSantos = ['Traslado de Todos los Santos' => CarbonImmutable::createFromDate($year, 11, 2)];
        $trasladoConstitucion = ['Traslado del Día de la Constitución' => CarbonImmutable::createFromDate($year, 12, 7)];

        return match ($this->region) {
            // Andalucía
            'es-an' => [
                'Día de Andalucía' => CarbonImmutable::createFromDate($year, 2, 28),
            ] + $juevesSanto + $trasladoTodosLosSantos + $trasladoConstitucion,

            // Aragón
            'es-ar' => [
                'San Jorge, Día de Aragón' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $trasladoTodosLosSantos + $trasladoConstitucion,

            // Principado de Asturias
            'es-as' => [
                'Día de Asturias' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $juevesSanto + $trasladoTodosLosSantos + $trasladoConstitucion,

            // Islas Baleares / Illes Balears
            'es-ib' => [
                'Lunes siguiente Día de les Illes Balears' => CarbonImmutable::createFromDate($year, 3, 2),
                'Segunda Fiesta de Navidad (Sant Esteve)' => CarbonImmutable::createFromDate($year, 12, 26),
            ] + $juevesSanto + $lunesPascua,

            // País Vasco / Euskal Herria
            'es-pv' => $sanJose + $juevesSanto + $lunesPascua + $santiagoApostol,

            // Canarias
            'es-cn' => [
                'Día de Canarias' => CarbonImmutable::createFromDate($year, 5, 30),
            ] + $juevesSanto + $trasladoTodosLosSantos,

            // Cantabria
            'es-cb' => [
                'Día de las Instituciones de Cantabria' => CarbonImmutable::createFromDate($year, 7, 28),
                'La Bien Aparecida' => CarbonImmutable::createFromDate($year, 9, 15),
            ] + $juevesSanto + $trasladoConstitucion,

            // Castilla-La Mancha
            'es-cm' => [
                'Corpus Christi' => CarbonImmutable::createFromDate($year, 6, 4),
            ] + $juevesSanto + $lunesPascua + $trasladoTodosLosSantos,

            // Castilla y León
            'es-cl' => [
                'Fiesta de la Comunidad Autónoma' => CarbonImmutable::createFromDate($year, 4, 23),
            ] + $juevesSanto + $trasladoTodosLosSantos + $trasladoConstitucion,

            // Cataluña / Catalunya
            'es-ct' => [
                'Diada Nacional de Cataluña' => CarbonImmutable::createFromDate($year, 9, 11),
                'Sant Esteve' => CarbonImmutable::createFromDate($year, 12, 26),
            ] + $lunesPascua + $sanJuan,

            // Extremadura
            'es-ex' => [
                'Día de Extremadura' => CarbonImmutable::createFromDate($year, 9, 8),
            ] + $juevesSanto + $trasladoTodosLosSantos + $trasladoConstitucion,

            // Galicia
            'es-ga' => [
                'Día Nacional de Galicia (Santiago Apóstol)' => CarbonImmutable::createFromDate($year, 7, 25),
            ] + $sanJose + $juevesSanto + $sanJuan,

            // La Rioja
            'es-ri' => [
                'Día de La Rioja' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $juevesSanto + $lunesPascua + $trasladoConstitucion,

            // Comunidad de Madrid
            'es-md' => [
                'Fiesta de la Comunidad de Madrid' => CarbonImmutable::createFromDate($year, 5, 2),
            ] + $juevesSanto + $trasladoTodosLosSantos + $trasladoConstitucion,

            // Región de Murcia
            'es-mc' => [
                'Día de la Región de Murcia' => CarbonImmutable::createFromDate($year, 6, 9),
            ] + $sanJose + $juevesSanto + $trasladoConstitucion,

            // Comunidad Foral de Navarra / Nafarroako Foru Komunitatea
            'es-nc' => [
                'San Francisco Javier' => CarbonImmutable::createFromDate($year, 12, 3),
            ] + $sanJose + $juevesSanto + $lunesPascua + $trasladoTodosLosSantos,

            // Comunidad Valenciana / Comunitat Valenciana
            'es-vc' => [
                'Día de la Comunitat Valenciana' => CarbonImmutable::createFromDate($year, 10, 9),
            ] + $sanJose + $lunesPascua + $sanJuan,

            // Ciudad Autónoma de Ceuta
            'es-ce' => [
                'Nuestra Señora de África' => CarbonImmutable::createFromDate($year, 8, 5),
                'Día de Ceuta' => CarbonImmutable::createFromDate($year, 9, 2),
            ] + $juevesSanto + $eidAlAdha,

            // Ciudad Autónoma de Melilla
            'es-ml' => [
                'Eid al-Fitr' => CarbonImmutable::createFromDate($year, 3, 20),
                'Virgen de la Victoria' => CarbonImmutable::createFromDate($year, 9, 8),
                'Día de Melilla' => CarbonImmutable::createFromDate($year, 9, 17),
            ] + $juevesSanto + $eidAlAdha + $trasladoConstitucion,

            null => [],
            default => throw InvalidRegion::notFound($this->region),
        };
    }
}
