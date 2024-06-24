<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class France extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {}

    public function countryCode(): string
    {
        return 'fr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "Jour de l'An" => '01-01',
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
        return match ($this->region) {
            'FR-57', 'FR-67', 'FR-68' => ['Saint-Étienne' => '12-26'],
            'FR-971', 'FR-MF' => ["Abolition de l'esclavage" => '05-27'],
            'FR-972' => ["Abolition de l'esclavage" => '05-22'],
            'FR-973' => ["Abolition de l'esclavage" => '06-10'],
            'FR-974' => ["Abolition de l'esclavage" => '12-20'],
            'FR-976' => ["Abolition de l'esclavage" => '04-27'],
            'FR-BL' => ["Abolition de l'esclavage" => '10-09'],
            default => [],
        };
    }
}
