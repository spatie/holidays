<?php

namespace Spatie\Holidays\Concerns;

use Carbon\CarbonImmutable;

trait IslamicHolidays
{
    protected function getIslamicHolidays(int $year): array
    {
        $countryCode = $this->countryCode();
        $dates = [];

        foreach (glob(__DIR__ . '/../../src/Calendars/Islamic/*.php') as $file) {
            $basename = basename($file, '.php');
            $holidayName = ucwords(str_replace("-", " ", $basename));

            $eventData = require $file;

            if (isset($eventData[$countryCode])) {
                $event = $eventData[$countryCode];

                if (isset($event['dates'][$year]['date'])) {
                    $holidayDate = $event['dates'][$year]['date'];
                    $duration = $eventData[$countryCode]['duration'];

                    if ($duration > 1) {
                        for ($i = 0; $i < $duration; $i++) {
                            $dates["$holidayName - " . ($i + 1)] = CarbonImmutable::createFromFormat(
                                'Y-m-d', "$year-$holidayDate"
                            )->addDays($i)->format('m-d');
                        }
                    } else {
                        $dates[$holidayName] = CarbonImmutable::createFromFormat(
                            'Y-m-d', "$year-$holidayDate"
                        )->format('m-d');
                    }
                }
            }
        }

        return $dates;
    }
}
