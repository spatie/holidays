<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;

class France extends Country implements HasRegions
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
        return ['FR-57', 'FR-67', 'FR-68', 'FR-971', 'FR-MF', 'FR-972', 'FR-973', 'FR-974', 'FR-976', 'FR-BL'];
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function countryCode(): string
    {
        return 'fr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            "Jour de l'An" => CarbonImmutable::createFromDate($year, 1, 1),
            'Fête du Travail' => CarbonImmutable::createFromDate($year, 5, 1),
            'Victoire 1945' => CarbonImmutable::createFromDate($year, 5, 8),
            'Fête Nationale' => CarbonImmutable::createFromDate($year, 7, 14),
            'Assomption' => CarbonImmutable::createFromDate($year, 8, 15),
            'Toussaint' => CarbonImmutable::createFromDate($year, 11, 1),
            'Armistice 1918' => CarbonImmutable::createFromDate($year, 11, 11),
            'Noël' => CarbonImmutable::createFromDate($year, 12, 25),
        ],
            $this->variableHolidays($year),
            $this->regionHolidays($year));
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

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays(int $year): array
    {
        return match ($this->region) {
            'FR-57', 'FR-67', 'FR-68' => ['Saint-Étienne' => CarbonImmutable::createFromDate($year, 12, 26)],
            'FR-971', 'FR-MF' => ["Abolition de l'esclavage" => CarbonImmutable::createFromDate($year, 5, 27)],
            'FR-972' => ["Abolition de l'esclavage" => CarbonImmutable::createFromDate($year, 5, 22)],
            'FR-973' => ["Abolition de l'esclavage" => CarbonImmutable::createFromDate($year, 6, 10)],
            'FR-974' => ["Abolition de l'esclavage" => CarbonImmutable::createFromDate($year, 12, 20)],
            'FR-976' => ["Abolition de l'esclavage" => CarbonImmutable::createFromDate($year, 4, 27)],
            'FR-BL' => ["Abolition de l'esclavage" => CarbonImmutable::createFromDate($year, 10, 9)],
            default => [],
        };
    }
}
