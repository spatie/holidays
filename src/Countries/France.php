<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

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
            Holiday::national("Jour de l'An", "{$year}-01-01"),
            Holiday::national('Fête du Travail', "{$year}-05-01"),
            Holiday::national('Victoire 1945', "{$year}-05-08"),
            Holiday::national('Fête Nationale', "{$year}-07-14"),
            Holiday::national('Assomption', "{$year}-08-15"),
            Holiday::national('Toussaint', "{$year}-11-01"),
            Holiday::national('Armistice 1918', "{$year}-11-11"),
            Holiday::national('Noël', "{$year}-12-25"),
        ],
            $this->variableHolidays($year),
            $this->regionHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        $holidays = [
            Holiday::national('Lundi de Pâques', $easter->addDay()),
            Holiday::national('Ascension', $easter->addDays(39)),
            Holiday::national('Lundi de Pentecôte', $easter->addDays(50)),
        ];

        if (in_array($this->region, ['FR-57', 'FR-67', 'FR-68'])) {
            $holidays[] = Holiday::national('Vendredi Saint', $easter->subDays(2));
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionHolidays(int $year): array
    {
        return match ($this->region) {
            'FR-57', 'FR-67', 'FR-68' => [Holiday::national('Saint-Étienne', "{$year}-12-26")],
            'FR-971', 'FR-MF' => [Holiday::national("Abolition de l'esclavage", "{$year}-05-27")],
            'FR-972' => [Holiday::national("Abolition de l'esclavage", "{$year}-05-22")],
            'FR-973' => [Holiday::national("Abolition de l'esclavage", "{$year}-06-10")],
            'FR-974' => [Holiday::national("Abolition de l'esclavage", "{$year}-12-20")],
            'FR-976' => [Holiday::national("Abolition de l'esclavage", "{$year}-04-27")],
            'FR-BL' => [Holiday::national("Abolition de l'esclavage", "{$year}-10-09")],
            default => [],
        };
    }
}
