<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Exceptions\InvalidRegion;

class Germany extends Country implements HasRegions, HasTranslations
{
    use Translatable;

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

    public function defaultLocale(): string
    {
        return 'de';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Neujahr' => CarbonImmutable::createFromDate($year, 1, 1),
            'Tag der Arbeit' => CarbonImmutable::createFromDate($year, 5, 1),
            '1. Weihnachtstag' => CarbonImmutable::createFromDate($year, 12, 25),
            '2. Weihnachtstag' => CarbonImmutable::createFromDate($year, 12, 26),
        ],
            $this->variableHolidays($year),
            $this->historicalHolidays($year),
            $this->regionHolidays($year)
        );
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            'Karfreitag' => $easter->subDays(2),
            'Ostermontag' => $easter->addDay(),
            'Himmelfahrt' => $easter->addDays(39),
            'Pfingstmontag' => $easter->addDays(50),
        ];
    }

    /** @return array<string, CarbonImmutable> */
    protected function historicalHolidays(int $year): array
    {
        $historicalHolidays = [];

        if ($year >= 1954 && $year <= 1990) {
            $historicalHolidays['Tag der deutschen Einheit'] = CarbonImmutable::createFromDate($year, 6, 17);
        } else {
            $historicalHolidays['Tag der deutschen Einheit'] = CarbonImmutable::createFromDate($year, 10, 3);
        }

        if ($year >= 1990 && $year <= 1994) {
            $historicalHolidays['Buß- und Bettag'] = $this->getRepentanceAndPrayerDay($year);
        }

        if ($year === 2017) {
            $historicalHolidays['Reformationstag'] = CarbonImmutable::createFromDate($year, 10, 31);
        }

        return $historicalHolidays;
    }

    /** @return array<string, CarbonImmutable> */
    protected function regionHolidays(int $year): array
    {
        $easter = $this->easter($year);

        switch ($this->region) {
            case 'DE-BW':
                return [
                    'Heilige Drei Könige' => CarbonImmutable::createFromDate($year, 1, 6),
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => CarbonImmutable::createFromDate($year, 11, 1),
                ];
            case 'DE-BY':
                $byHolidays = [
                    'Heilige Drei Könige' => CarbonImmutable::createFromDate($year, 1, 6),
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => CarbonImmutable::createFromDate($year, 11, 1),
                    'Mariä Himmelfahrt' => CarbonImmutable::createFromDate($year, 8, 15),
                ];
                if ($year >= 1948 && $year <= 1969) {
                    $byHolidays['Josefstag'] = CarbonImmutable::createFromDate($year, 3, 19);
                }

                return $byHolidays;

            case 'DE-BE':
                $beHolidays = [
                ];
                if ($year >= 2019) {
                    $beHolidays['Internationaler Frauentag'] = CarbonImmutable::createFromDate($year, 3, 8);
                }

                if ($year === 2020 || $year === 2025) {
                    $beHolidays['Tag der Befreiung'] = CarbonImmutable::createFromDate($year, 5, 8);
                }

                if ($year === 2028) {
                    $beHolidays['75-jähriges Jubiläum des Volksaufstands in der DDR'] = CarbonImmutable::createFromDate($year, 6, 17);
                }

                return $beHolidays;
            case 'DE-BB':
                if ($year >= 1991) {
                    return [
                        'Ostersonntag' => $easter,
                        'Reformationstag' => CarbonImmutable::createFromDate($year, 10, 31),
                        'Pfingstsonntag' => $easter->addDays(49),
                    ];
                }

                return [
                    'Ostersonntag' => $easter,
                    'Pfingstsonntag' => $easter->addDays(49),
                ];
            case 'DE-HB':
            case 'DE-HH':
            case 'DE-NI':
            case 'DE-SH':
                if ($year >= 2017) {
                    return [
                        'Reformationstag' => CarbonImmutable::createFromDate($year, 10, 31),
                    ];
                }

                return [];

            case 'DE-HE':
                return [
                    'Ostersonntag' => $easter,
                    'Pfingstsonntag' => $easter->addDays(49),
                    'Fronleichnam' => $easter->addDays(60),
                ];
            case 'DE-MV':
                $mvHolidays = [];
                if ($year >= 1990) {
                    $mvHolidays['Reformationstag'] = CarbonImmutable::createFromDate($year, 10, 31);
                }

                if ($year >= 2023) {
                    $mvHolidays['Internationaler Frauentag'] = CarbonImmutable::createFromDate($year, 3, 8);
                }

                return $mvHolidays;
            case 'DE-NW':
            case 'DE-RP':

                return [
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => CarbonImmutable::createFromDate($year, 11, 1),
                ];
            case 'DE-SL':
                return [
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => CarbonImmutable::createFromDate($year, 11, 1),
                    'Mariä Himmelfahrt' => CarbonImmutable::createFromDate($year, 8, 15),
                ];
            case 'DE-SN':
                $snHolidays = [];
                if ($year >= 1990) {
                    $snHolidays['Reformationstag'] = CarbonImmutable::createFromDate($year, 10, 31);

                }

                if ($year > 1994) {
                    $snHolidays['Buß- und Bettag'] = $this->getRepentanceAndPrayerDay($year);

                }

                return $snHolidays;
            case 'DE-ST':
                $stHolidays = [];
                if ($year >= 1990) {
                    $stHolidays['Reformationstag'] = CarbonImmutable::createFromDate($year, 10, 31);

                }

                if ($year >= 1991) {
                    $stHolidays['Heilige Drei Könige'] = CarbonImmutable::createFromDate($year, 1, 6);
                }

                return $stHolidays;
            case 'DE-TH':
                $thHolidays = [];
                if ($year >= 1990) {
                    $thHolidays['Reformationstag'] = CarbonImmutable::createFromDate($year, 10, 31);
                }

                if ($year >= 2019) {
                    $thHolidays['Weltkindertag'] = CarbonImmutable::createFromDate($year, 9, 20);
                }

                return $thHolidays;
        }

        return [];
    }

    protected function getRepentanceAndPrayerDay(int $year): CarbonImmutable
    {
        return new CarbonImmutable('next wednesday '.$year.'-11-15')->startOfDay();
    }
}
