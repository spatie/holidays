<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use IntlCalendar;

class Uganda extends Country
{
    public function countryCode(): string
    {
        return 'ug';
    }

    /** @return array<string, CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'International Women\'s Day' => '03-08',
            'Labor Day' => '05-01',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26'
        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Africa/Kampala');

        // Eid al-Fitr is on the first day of the 10th month in the calendar
        // since the PHP array index begins at 0, it is the 9th month
        $eid_al_fitr_cal = IntlCalendar::createInstance('Africa/Kampala', '@calendar=islamic-rgsa');
        $eid_al_fitr_cal->set(IntlCalendar::FIELD_MONTH, 9);
        $eid_al_fitr_cal->set(IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_HOUR_OF_DAY);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_MINUTE);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_SECOND);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_MILLISECOND);

        // Eid al-Adha is on the 10th day of the Dhu al-Hijja the 12th month in the calendar
        // since the PHP array index begins at 0, it is the 11th month
        $eid_al_adha_cal = IntlCalendar::createInstance('Africa/Kampala', '@calendar=islamic-civil');
        $eid_al_adha_cal->set(IntlCalendar::FIELD_MONTH, 11);
        $eid_al_adha_cal->set(IntlCalendar::FIELD_DAY_OF_MONTH, 10);
        $eid_al_adha_cal->clear(IntlCalendar::FIELD_HOUR_OF_DAY);
        $eid_al_adha_cal->clear(IntlCalendar::FIELD_MINUTE);
        $eid_al_adha_cal->clear(IntlCalendar::FIELD_SECOND);
        $eid_al_adha_cal->clear(IntlCalendar::FIELD_MILLISECOND);

        $variable_holidays = array(
            'Easter Monday' => $easter->addDay(),
            'Good Friday' => $easter->addDays(-2),
            'Eid al-Fitr' => CarbonImmutable::createFromTimestamp($eid_al_fitr_cal->toDateTime()->getTimestamp()),
            'Eid al-Adha' => CarbonImmutable::createFromTimestamp($eid_al_adha_cal->toDateTime()->getTimestamp())
        );

        // Independence day celebrations started in 1962
        if ($year >= 1962) {
            $variable_holidays['Independence Day of Uganda'] = '10-09';
        }

        // Martyr's day celebrations started in 1964
        if ($year >= 1964) {
           $variable_holidays['Uganda Martyr\'s Day'] = '06-03';
        }

        //  'NRM Liberation Day celebrations started in 1987
        if ($year >= 1987) {
            $variable_holidays['NRM Liberation Day'] = '01-26';
        }

        // National Heroes day celebration started in 2001
        if ($year >= 2001) {
            $variable_holidays['National Heroes\' Day'] = '06-09';
        }

        // Archbishop Janani Luwum Memorial Day celebrations started in 2015
        if ($year >= 2015) {
            $variable_holidays['Archbishop Janani Luwum Memorial Day'] = '02-16';
        }

        return $variable_holidays;
    }
}
