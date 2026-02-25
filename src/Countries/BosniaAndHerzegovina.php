<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;

class BosniaAndHerzegovina extends Country implements HasRegions
{
    protected const REGIONS = [
        'ba-rs',
        'ba-fbih',
        'ba-bd',
    ];

    public function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, self::REGIONS)) {
            throw InvalidRegion::notFound($region);
        }
    }

    public static function regions(): array
    {
        return self::REGIONS;
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function countryCode(): string
    {
        return 'ba';
    }

    protected function defaultLocale(): string
    {
        return 'hr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nova godina - prvi dan' => CarbonImmutable::createFromDate($year, 1, 1),
            'Nova godina - drugi dan' => CarbonImmutable::createFromDate($year, 1, 2),
            'Badnji dan (za pravoslavce)' => CarbonImmutable::createFromDate($year, 1, 6),
            'Božić (za pravoslavce)' => CarbonImmutable::createFromDate($year, 1, 7),
            'Praznik rada - prvi dan' => CarbonImmutable::createFromDate($year, 5, 1),
            'Praznik rada - drugi dan' => CarbonImmutable::createFromDate($year, 5, 2),
            'Badnji dan (za rimokatolike)' => CarbonImmutable::createFromDate($year, 12, 24),
            'Božić (za rimokatolike)' => CarbonImmutable::createFromDate($year, 12, 25),
        ], $this->regionHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays(int $year): array
    {
        return match ($this->region) {
            'ba-rs' => [
                'Dan Republike' => CarbonImmutable::createFromDate($year, 1, 9),
                'Dan pobjede nad fašizmom' => CarbonImmutable::createFromDate($year, 5, 9),
                'Dan uspostavljanja Opšteg okvirnog sporazuma za mir u BiH' => CarbonImmutable::createFromDate($year, 11, 21),
            ],
            'ba-fbih' => [
                'Dan nezavisnosti Bosne i Hercegovine' => CarbonImmutable::createFromDate($year, 3, 1),
                'Dan državnosti Bosne i Hercegovine' => CarbonImmutable::createFromDate($year, 11, 25),
            ],
            'ba-bd' => [
                'Dan uspostavljanja Brčko distrikta' => CarbonImmutable::createFromDate($year, 3, 8),
            ],
            default => [],
        };
    }

    /** @return array<string, CarbonImmutable> */
    public function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);
        $orthodoxGoodFriday = $orthodoxEaster->copy()->subDays(2);
        $orthodoxEasterMonday = $orthodoxEaster->copy()->addDay();

        $easter = $this->easter($year);
        $goodFriday = $easter->copy()->subDays(2);
        $easterMonday = $easter->copy()->addDay();

        // TODO: Implement islamic holidays

        return [
            // Orthodox holidays
            'Vaskrs (za pravoslavce)' => $orthodoxEaster,
            'Vaskršnji ponedjeljak (za pravoslavce)' => $orthodoxEasterMonday,
            'Veliki petak (za pravoslavce)' => $orthodoxGoodFriday,

            // Catholic holidays
            'Vaskrs (za rimokatolike)' => $easter,
            'Vaskršnji ponedjeljak (za rimokatolike)' => $easterMonday,
            'Veliki petak (za rimokatolike)' => $goodFriday,
        ];
    }
}
