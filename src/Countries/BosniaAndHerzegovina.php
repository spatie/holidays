<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

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
            Holiday::national('Nova godina - prvi dan', "{$year}-01-01"),
            Holiday::national('Nova godina - drugi dan', "{$year}-01-02"),
            Holiday::national('Badnji dan (za pravoslavce)', "{$year}-01-06"),
            Holiday::national('Božić (za pravoslavce)', "{$year}-01-07"),
            Holiday::national('Praznik rada - prvi dan', "{$year}-05-01"),
            Holiday::national('Praznik rada - drugi dan', "{$year}-05-02"),
            Holiday::national('Badnji dan (za rimokatolike)', "{$year}-12-24"),
            Holiday::national('Božić (za rimokatolike)', "{$year}-12-25"),
        ], $this->regionHolidays($year));
    }

    /** @return array<Holiday> */
    protected function regionHolidays(int $year): array
    {
        return match ($this->region) {
            'ba-rs' => [
                Holiday::national('Dan Republike', "{$year}-01-09"),
                Holiday::national('Dan pobjede nad fašizmom', "{$year}-05-09"),
                Holiday::national('Dan uspostavljanja Opšteg okvirnog sporazuma za mir u BiH', "{$year}-11-21"),
            ],
            'ba-fbih' => [
                Holiday::national('Dan nezavisnosti Bosne i Hercegovine', "{$year}-03-01"),
                Holiday::national('Dan državnosti Bosne i Hercegovine', "{$year}-11-25"),
            ],
            'ba-bd' => [
                Holiday::national('Dan uspostavljanja Brčko distrikta', "{$year}-03-08"),
            ],
            default => [],
        };
    }

    /** @return array<Holiday> */
    public function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);
        $orthodoxGoodFriday = $orthodoxEaster->copy()->subDays(2);
        $orthodoxEasterMonday = $orthodoxEaster->copy()->addDay();

        $easter = $this->easter($year);
        $goodFriday = $easter->copy()->subDays(2);
        $easterMonday = $easter->copy()->addDay();

        return [
            Holiday::national('Vaskrs (za pravoslavce)', $orthodoxEaster),
            Holiday::national('Vaskršnji ponedjeljak (za pravoslavce)', $orthodoxEasterMonday),
            Holiday::national('Veliki petak (za pravoslavce)', $orthodoxGoodFriday),
            Holiday::national('Vaskrs (za rimokatolike)', $easter),
            Holiday::national('Vaskršnji ponedjeljak (za rimokatolike)', $easterMonday),
            Holiday::national('Veliki petak (za rimokatolike)', $goodFriday),
        ];
    }
}
