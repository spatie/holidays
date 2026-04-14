<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

class Germany extends Country implements HasRegions
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
        return ['DE-BW', 'DE-BY', 'DE-BE', 'DE-BB', 'DE-HB', 'DE-HH', 'DE-HE', 'DE-MV', 'DE-NI', 'DE-NW', 'DE-RP', 'DE-SL', 'DE-SN', 'DE-ST', 'DE-SH', 'DE-TH'];
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function countryCode(): string
    {
        return 'de';
    }

    protected function defaultLocale(): string
    {
        return 'de';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Neujahr', "{$year}-01-01"),
            Holiday::national('Tag der Arbeit', "{$year}-05-01"),
            Holiday::national('1. Weihnachtstag', "{$year}-12-25"),
            Holiday::national('2. Weihnachtstag', "{$year}-12-26"),
        ],
            $this->variableHolidays($year),
            $this->historicalHolidays($year),
            $this->regionHolidays($year)
        );
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Karfreitag', $easter->subDays(2)),
            Holiday::national('Ostermontag', $easter->addDay()),
            Holiday::national('Himmelfahrt', $easter->addDays(39)),
            Holiday::national('Pfingstmontag', $easter->addDays(50)),
        ];
    }

    /** @return array<Holiday> */
    protected function historicalHolidays(int $year): array
    {
        $holidays = [];

        $holidays[] = Holiday::national('Tag der deutschen Einheit', ($year >= 1954 && $year <= 1990)
            ? "{$year}-06-17"
            : "{$year}-10-03");

        if ($year >= 1990 && $year <= 1994) {
            $holidays[] = Holiday::national('Buß- und Bettag', $this->getRepentanceAndPrayerDay($year));
        }

        if ($year === 2017) {
            $holidays[] = Holiday::national('Reformationstag', "{$year}-10-31");
        }

        return $holidays;
    }

    /** @return array<Holiday> */
    protected function regionHolidays(int $year): array
    {
        $easter = $this->easter($year);

        switch ($this->region) {
            case 'DE-BW':
                return [
                    Holiday::regional('Heilige Drei Könige', "{$year}-01-06", 'DE-BW'),
                    Holiday::regional('Fronleichnam', $easter->addDays(60), 'DE-BW'),
                    Holiday::regional('Allerheiligen', "{$year}-11-01", 'DE-BW'),
                ];
            case 'DE-BY':
                $byHolidays = [
                    Holiday::regional('Heilige Drei Könige', "{$year}-01-06", 'DE-BY'),
                    Holiday::regional('Fronleichnam', $easter->addDays(60), 'DE-BY'),
                    Holiday::regional('Allerheiligen', "{$year}-11-01", 'DE-BY'),
                    Holiday::regional('Mariä Himmelfahrt', "{$year}-08-15", 'DE-BY'),
                ];
                if ($year >= 1948 && $year <= 1969) {
                    $byHolidays[] = Holiday::regional('Josefstag', "{$year}-03-19", 'DE-BY');
                }

                return $byHolidays;

            case 'DE-BE':
                $beHolidays = [];
                if ($year >= 2019) {
                    $beHolidays[] = Holiday::regional('Internationaler Frauentag', "{$year}-03-08", 'DE-BE');
                }

                if ($year === 2020 || $year === 2025) {
                    $beHolidays[] = Holiday::regional('Tag der Befreiung', "{$year}-05-08", 'DE-BE');
                }

                if ($year === 2028) {
                    $beHolidays[] = Holiday::regional('75-jähriges Jubiläum des Volksaufstands in der DDR', "{$year}-06-17", 'DE-BE');
                }

                return $beHolidays;
            case 'DE-BB':
                if ($year >= 1991) {
                    return [
                        Holiday::regional('Ostersonntag', $easter, 'DE-BB'),
                        Holiday::regional('Reformationstag', "{$year}-10-31", 'DE-BB'),
                        Holiday::regional('Pfingstsonntag', $easter->addDays(49), 'DE-BB'),
                    ];
                }

                return [
                    Holiday::regional('Ostersonntag', $easter, 'DE-BB'),
                    Holiday::regional('Pfingstsonntag', $easter->addDays(49), 'DE-BB'),
                ];
            case 'DE-HB':
            case 'DE-HH':
            case 'DE-NI':
            case 'DE-SH':
                if ($year >= 2017) {
                    return [
                        Holiday::regional('Reformationstag', "{$year}-10-31", $this->region),
                    ];
                }

                return [];

            case 'DE-HE':
                return [
                    Holiday::regional('Ostersonntag', $easter, 'DE-HE'),
                    Holiday::regional('Pfingstsonntag', $easter->addDays(49), 'DE-HE'),
                    Holiday::regional('Fronleichnam', $easter->addDays(60), 'DE-HE'),
                ];
            case 'DE-MV':
                $mvHolidays = [];
                if ($year >= 1990) {
                    $mvHolidays[] = Holiday::regional('Reformationstag', "{$year}-10-31", 'DE-MV');
                }

                if ($year >= 2023) {
                    $mvHolidays[] = Holiday::regional('Internationaler Frauentag', "{$year}-03-08", 'DE-MV');
                }

                return $mvHolidays;
            case 'DE-NW':
            case 'DE-RP':

                return [
                    Holiday::regional('Fronleichnam', $easter->addDays(60), $this->region),
                    Holiday::regional('Allerheiligen', "{$year}-11-01", $this->region),
                ];
            case 'DE-SL':
                return [
                    Holiday::regional('Fronleichnam', $easter->addDays(60), 'DE-SL'),
                    Holiday::regional('Allerheiligen', "{$year}-11-01", 'DE-SL'),
                    Holiday::regional('Mariä Himmelfahrt', "{$year}-08-15", 'DE-SL'),
                ];
            case 'DE-SN':
                $snHolidays = [];
                if ($year >= 1990) {
                    $snHolidays[] = Holiday::regional('Reformationstag', "{$year}-10-31", 'DE-SN');

                }

                if ($year > 1994) {
                    $snHolidays[] = Holiday::regional('Buß- und Bettag', $this->getRepentanceAndPrayerDay($year), 'DE-SN');

                }

                return $snHolidays;
            case 'DE-ST':
                $stHolidays = [];
                if ($year >= 1990) {
                    $stHolidays[] = Holiday::regional('Reformationstag', "{$year}-10-31", 'DE-ST');

                }

                if ($year >= 1991) {
                    $stHolidays[] = Holiday::regional('Heilige Drei Könige', "{$year}-01-06", 'DE-ST');
                }

                return $stHolidays;
            case 'DE-TH':
                $thHolidays = [];
                if ($year >= 1990) {
                    $thHolidays[] = Holiday::regional('Reformationstag', "{$year}-10-31", 'DE-TH');
                }

                if ($year >= 2019) {
                    $thHolidays[] = Holiday::regional('Weltkindertag', "{$year}-09-20", 'DE-TH');
                }

                return $thHolidays;
        }

        return [];
    }

    protected function getRepentanceAndPrayerDay(int $year): CarbonImmutable
    {
        return new CarbonImmutable("next wednesday {$year}-11-15")->startOfDay();
    }
}
