<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Contracts\HasRegions;
use Spatie\Holidays\Exceptions\InvalidRegion;
use Spatie\Holidays\Holiday;

class Australia extends Country implements HasRegions
{
    protected function __construct(protected ?string $region = null)
    {
        if ($region !== null && ! in_array($region, static::regions())) {
            throw InvalidRegion::notFound($region);
        }
    }

    /** @return array<string> */
    public static function regions(): array
    {
        return ['act', 'nsw', 'nt', 'qld', 'sa', 'tas', 'vic', 'wa'];
    }

    public function region(): ?string
    {
        return $this->region;
    }

    public function countryCode(): string
    {
        return 'au';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national("New Year's Day", "{$year}-01-01"),
            Holiday::national('Australia Day', "{$year}-01-26"),
            Holiday::national('Anzac Day', "{$year}-04-25"),
            Holiday::national('Christmas Day', "{$year}-12-25"),
            Holiday::national('Boxing Day', "{$year}-12-26"),
        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year);

        return [
            Holiday::national('Good Friday', $easter->subDays(2)),
            Holiday::national('Easter Monday', $easter->addDay()),
            // https://en.wikipedia.org/wiki/Public_holidays_in_Australia
            ...match ($this->region) {
                'act' => [
                    Holiday::national('Canberra Day', CarbonImmutable::parse("second monday of march {$year}")),
                    Holiday::national('Easter Saturday', $easter->subDay()),
                    Holiday::national('Easter Sunday', $easter),
                    ...(($reconciliationDay = CarbonImmutable::create($year, 5, 27)?->modify('monday'))
                        ? [Holiday::national('Reconciliation Day', $reconciliationDay)]
                        : []),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("second monday of june {$year}")),
                    Holiday::national('Labour Day', CarbonImmutable::parse("first monday of october {$year}")),
                ],
                'nsw' => [
                    Holiday::national('Easter Saturday', $easter->subDay()),
                    Holiday::national('Easter Sunday', $easter),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("second monday of june {$year}")),
                    Holiday::national('Labour Day', CarbonImmutable::parse("first monday of october {$year}")),
                ],
                'nt' => [
                    Holiday::national('Easter Saturday', $easter->subDay()),
                    Holiday::national('May Day', CarbonImmutable::parse("first monday of may {$year}")),
                    Holiday::national('Picnic Day', CarbonImmutable::parse("first monday of august {$year}")),
                ],
                'qld' => [
                    Holiday::national('The day after Good Friday', $easter->subDay()),
                    Holiday::national('Easter Sunday', $easter),
                    Holiday::national('Labour Day', CarbonImmutable::parse("first monday of may {$year}")),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("first monday of october {$year}")),
                ],
                'sa' => [
                    Holiday::national('Adelaide Cup Day', $year < 2006
                        ? CarbonImmutable::parse("third monday of may {$year}")
                        : CarbonImmutable::parse("second monday of march {$year}")),
                    Holiday::national('The day after Good Friday', $easter->subDay()),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("second monday of june {$year}")),
                    Holiday::national('Labour Day', CarbonImmutable::parse("first monday of october {$year}")),
                ],
                'tas' => [
                    Holiday::national('Eight Hours Day', CarbonImmutable::parse("second monday of march {$year}")),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("second monday of june {$year}")),
                ],
                'vic' => [
                    Holiday::national('Labour Day', CarbonImmutable::parse("second monday of march {$year}")),
                    Holiday::national('Saturday before Easter Sunday', $easter->subDay()),
                    Holiday::national('Easter Sunday', $easter),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("second monday of june {$year}")),
                    ...($this->fridayBeforeAflGrandFinal($year)
                        ? [Holiday::national('Friday before AFL Grand Final', $this->fridayBeforeAflGrandFinal($year))]
                        : []),
                    Holiday::national('Melbourne Cup', CarbonImmutable::parse("first tuesday of november {$year}")),
                ],
                'wa' => [
                    Holiday::national('Labour Day', CarbonImmutable::parse("first monday of march {$year}")),
                    Holiday::national('Easter Sunday', $easter),
                    Holiday::national('Western Australia Day', CarbonImmutable::parse("first monday of june {$year}")),
                    Holiday::national($this->sovereignBirthdayKey($year), CarbonImmutable::parse("last monday of september {$year}")),
                ],
                default => [],
            },
        ];
    }

    // https://business.vic.gov.au/business-information/public-holidays/victorian-public-holidays-2025
    // https://en.wikipedia.org/wiki/List_of_VFL/AFL_premiers#VFL/AFL_premierships
    protected function fridayBeforeAflGrandFinal(int $year): ?CarbonImmutable
    {
        if ($year < 2015) {
            return null;
        }

        return match ($year) {
            2015 => CarbonImmutable::parse('2015-10-02'),
            2020 => CarbonImmutable::parse('2020-10-23'),
            2022 => CarbonImmutable::parse('2022-09-23'),
            default => CarbonImmutable::parse("last friday of september {$year}"),
        };
    }

    protected function sovereignBirthdayKey(int $year): string
    {
        // https://www.abc.net.au/news/2022-09-22/queens-birthday-public-holiday-becomes-kings-birthday/101453408
        $changeYear = $this->region === 'wa' ? 2022 : 2023;

        return $year >= $changeYear ? "King's Birthday" : "Queen's Birthday";
    }
}
