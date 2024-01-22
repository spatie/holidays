<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Australia extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    public function countryCode(): string
    {
        return 'au';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Australia Day' => '01-26',
            'Anzac Day' => '04-25',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26',
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = $this->easter($year)->setTimezone('Australia/Sydney');

        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
            // https://en.wikipedia.org/wiki/Public_holidays_in_Australia
            ...array_filter(match($this->region) {
                'act' => [
                    'Canberra Day' => CarbonImmutable::parse("second monday of march {$year}"),
                    'Easter Saturday' => $easter->subDay(),
                    'Easter Sunday' => $easter,
                    'Reconciliation Day' => CarbonImmutable::create($year, 5, 27)->modify("monday"),
                    'King\'s Birthday' => $year >= 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Queen\'s Birthday' => $year < 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Labour Day' => CarbonImmutable::parse("first monday of october {$year}"),
                ],
                'nsw' => [
                    'Easter Saturday' => $easter->subDay(),
                    'Easter Sunday' => $easter,
                    'King\'s Birthday' => $year >= 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Queen\'s Birthday' => $year < 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Labour Day' => CarbonImmutable::parse("first monday of october {$year}"),
                ],
                'nt' => [
                    'Easter Saturday' => $easter->subDay(),
                    'May Day' => CarbonImmutable::parse("first monday of may {$year}"),
                    'Picnic Day' => CarbonImmutable::parse("first monday of august {$year}"),
                ],
                'qld' => [
                    'The day after Good Friday' => $easter->subDay(),
                    'Easter Sunday' => $easter,
                    'Labour Day' => CarbonImmutable::parse("first monday of may {$year}"),
                    'King\'s Birthday' => $year >= 2023 ? CarbonImmutable::parse("first monday of october {$year}") : null,
                    'Queen\'s Birthday' => $year < 2023 ? CarbonImmutable::parse("first monday of october {$year}") : null,
                ],
                'sa' => [
                    'Adelaide Cup Day' => $year < 2006
                        ? CarbonImmutable::parse("third monday of may {$year}")
                        : CarbonImmutable::parse("second monday of march {$year}"),
                    'The day after Good Friday' => $easter->subDay(),
                    'King\'s Birthday' => $year >= 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Queen\'s Birthday' => $year < 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Labour Day' => CarbonImmutable::parse("first monday of october {$year}"),
                ],
                'tas' => [
                    'Eight Hours Day' => CarbonImmutable::parse("second monday of march {$year}"),
                    'King\'s Birthday' => $year >= 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Queen\'s Birthday' => $year < 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                ],
                'vic' => [
                    'Labour Day' => CarbonImmutable::parse("second monday of march {$year}"),
                    'Saturday before Easter Sunday' => $easter->subDay(),
                    'Easter Sunday' => $easter,
                    'King\'s Birthday' => $year >= 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Queen\'s Birthday' => $year < 2023 ? CarbonImmutable::parse("second monday of june {$year}") : null,
                    'Friday before AFL Grand Final' => $this->fridayBeforeAflGrandFinal($year),
                    'Melbourne Cup' => CarbonImmutable::parse("first tuesday of november {$year}"),
                ],
                'wa' => [
                    'Labour Day' => CarbonImmutable::parse("first monday of march {$year}"),
                    'Easter Sunday' => $easter,
                    'Western Australia Day' => CarbonImmutable::parse("first monday of june {$year}"),
                    // https://www.abc.net.au/news/2022-09-22/queens-birthday-public-holiday-becomes-kings-birthday/101453408
                    'King\'s Birthday' => $year >= 2022 ? CarbonImmutable::parse("last monday of september {$year}") : null,
                    'Queen\'s Birthday' => $year < 2022 ? CarbonImmutable::parse("last monday of september {$year}") : null,
                ],
                default => [],
            }),
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
}
