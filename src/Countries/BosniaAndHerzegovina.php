<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Exceptions\InvalidRegion;

class BosniaAndHerzegovina extends Country implements HasTranslations
{
    use Translatable;

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

    public function countryCode(): string
    {
        return 'ba';
    }

    public function defaultLocale(): string
    {
        return 'hr';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Nova godina - prvi dan' => '01-01',
            'Nova godina - drugi dan' => '01-02',
            'Badnji dan (za pravoslavce)' => '01-06',
            'Božić (za pravoslavce)' => '01-07',
            'Praznik rada - prvi dan' => '05-01',
            'Praznik rada - drugi dan' => '05-02',
            'Badnji dan (za rimokatolike)' => '12-24',
            'Božić (za rimokatolike)' => '12-25',
        ], $this->regionHolidays());
    }

    /** @return array<string, string> */
    protected function regionHolidays(): array
    {
        return match ($this->region) {
            'ba-rs' => [
                'Dan Republike' => '01-09',
                'Dan pobjede nad fašizmom' => '05-09',
                'Dan uspostavljanja Opšteg okvirnog sporazuma za mir u BiH' => '11-21',
            ],
            'ba-fbih' => [
                'Dan nezavisnosti Bosne i Hercegovine' => '03-01',
                'Dan državnosti Bosne i Hercegovine' => '11-25',
            ],
            'ba-bd' => [
                'Dan uspostavljanja Brčko distrikta' => '03-08',
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
