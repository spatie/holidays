<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class England extends Country
{
  public function countryCode(): string
  {
    return 'en';
  }

  protected function allHolidays(int $year): array
  {
    return array_merge([
      'New Year\'s Day' => new CarbonImmutable($year . "-01-01", 'Europe/London'),
      'Early May bank holiday' => new CarbonImmutable("first monday of may {$year}", 'Europe/London'),
      'Spring bank holiday' => new CarbonImmutable("last monday of may {$year}", 'Europe/London'),
      'Summer bank holiday' => new CarbonImmutable("last monday of august {$year}", 'Europe/London'),
      'Christmas Day' => new CarbonImmutable($year . "-12-25", 'Europe/London'),
      'Boxing Day' => new CarbonImmutable($year . "-12-26", 'Europe/London'),
    ], $this->variableHolidays($year));
  }

  protected function variableHolidays(int $year): array
  {
    $easterSunday = CarbonImmutable::createFromTimestamp(easter_date($year))
      ->setTimezone('Europe/London');

    $goodFriday = $easterSunday->subDays(2);
    $easterMonday = $easterSunday->addDays(1);

    return [
      'Good Friday' => $goodFriday,
      'Easter Monday' => $easterMonday,
    ];
  }
}
