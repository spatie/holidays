<?php declare(strict_types=1);

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

final class Paraguay extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'py';
    }

    public function defaultLocale(): string
    {
        return 'es';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Año Nuevo' => '01-01',
            'Día de los Héroes' => '03-01',
            'Día del Trabajador' => '05-01',
            'Día de la Independencia Nacional' => '05-15',
            'Fundación de Asunción' => '08-15',
            'Batalla de Boquerón' => '09-29',
            'Virgen de Caacupé' => '12-08',
            'Navidad' => '12-25',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    private function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Paz del Chaco' => $this->chacoArmistice($year),
            'Jueves Santo'  => $easter->subDays(3),
            'Viernes Santo' => $easter->subDays(2),
        ];
    }

    private function chacoArmistice(int $year): CarbonImmutable
    {
        // In 2014, the Day of Chaco Armistice was moved to June 16th (Decree N.º 280 signed in September 2013)
        // For later years, the date remains as June 12th
        return CarbonImmutable::createFromDate($year, 06, $year === 2014 ? 16 : 12);
    }
}
