<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class France extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    public function countryCode(): string
    {
        return 'fr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Jour de l\'An' => '01-01',
            'Fête du Travail' => '05-01',
            'Victoire 1945' => '05-08',
            'Fête Nationale' => '07-14',
            'Assomption' => '08-15',
            'Toussaint' => '11-01',
            'Armistice 1918' => '11-11',
            'Noël' => '12-25',
        ],
            $this->variableHolidays($year),
            $this->regionHolidays());
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $holidays = [
            'Lundi de Pâques' => $easter->addDay(),
            'Ascension' => $easter->addDays(39),
            'Lundi de Pentecôte' => $easter->addDays(50),
        ];

        if (in_array($this->region, ['FR-57', 'FR-67', 'FR-68'])) {
            $holidays['Vendredi Saint'] = $easter->subDays(2);
        }

        return $holidays;
    }

    /** @return array<string, string> */
    protected function regionHolidays(): array
    {
        switch ($this->region) {
            case 'FR-57':
            case 'FR-67':
            case 'FR-68':
                return ['Saint-Étienne' => '12-26'];
            case 'FR-971':
            case 'FR-MF':
                return ['Abolition de l\'esclavage' => '05-27'];
            case 'FR-972':
                return ['Abolition de l\'esclavage' => '05-22'];
            case 'FR-973':
                return ['Abolition de l\'esclavage' => '06-10'];
            case 'FR-974':
                return ['Abolition de l\'esclavage' => '12-20'];
            case 'FR-976':
                return ['Abolition de l\'esclavage' => '04-27'];
            case 'FR-BL':
                return ['Abolition de l\'esclavage' => '10-09'];
        }

        return [];
    }
}
