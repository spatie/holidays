<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Japan extends Country
{
    public function countryCode(): string
    {
        return 'jp';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('元日', "{$year}-01-01"),
            Holiday::national('建国記念の日', "{$year}-02-11"),
            Holiday::national('天皇誕生日', "{$year}-02-23"),
            Holiday::national('春分の日', "{$year}-03-20"),
            Holiday::national('昭和の日', "{$year}-04-29"),
            Holiday::national('憲法記念日', "{$year}-05-03"),
            Holiday::national('みどりの日', "{$year}-05-04"),
            Holiday::national('こどもの日', "{$year}-05-05"),
            Holiday::national('山の日', "{$year}-08-11"),
            Holiday::national('秋分の日', "{$year}-09-23"),
            Holiday::national('文化の日', "{$year}-11-03"),
            Holiday::national('勤労感謝の日', "{$year}-11-23"),

        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {
        return [
            Holiday::national('成人の日', CarbonImmutable::parse("second monday of january {$year}")),
            Holiday::national('海の日', CarbonImmutable::parse("third monday of july {$year}")),
            Holiday::national('敬老の日', CarbonImmutable::parse("third monday of september {$year}")),
            Holiday::national('スポーツの日', CarbonImmutable::parse("second monday of october {$year}")),
        ];
    }
}
