<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use IntlCalendar;

class Tanzania extends Country
{
    public function countryCode(): string
    {
        return 'tz';
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '01-01',
            'Labor Day' => '05-01',
            'Saba Saba Day' => '07-07',
            'Farmers Day (Nane Nane Day)' => '08-08',
            'Christmas Day' => '12-25',
            'Boxing Day' => '12-26'
        ], $this->variableHolidays($year));
    }

    /** @return array<string, string|CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year))
            ->setTimezone('Africa/Dar_es_Salaam');

        // Eid al-Fitr is on the first day of the 10th month in the calendar
        // since the PHP array index begins at 0, it is the 9th month
        $eid_al_fitr_cal = IntlCalendar::createInstance('Africa/Dar_es_Salaam', '@calendar=islamic-rgsa');
        $eid_al_fitr_cal->set(IntlCalendar::FIELD_MONTH, 9);
        $eid_al_fitr_cal->set(IntlCalendar::FIELD_DAY_OF_MONTH, 1);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_HOUR_OF_DAY);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_MINUTE);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_SECOND);
        $eid_al_fitr_cal->clear(IntlCalendar::FIELD_MILLISECOND);

        // Eid al-Hajj is on the 10th day of the Dhu al-Hijja the 12th month in the calendar
        // since the PHP array index begins at 0, it is the 11th month
        $eid_al_hajj_cal = IntlCalendar::createInstance('Africa/Dar_es_Salaam', '@calendar=islamic-civil');
        $eid_al_hajj_cal->set(IntlCalendar::FIELD_MONTH, 11);
        $eid_al_hajj_cal->set(IntlCalendar::FIELD_DAY_OF_MONTH, 10);
        $eid_al_hajj_cal->clear(IntlCalendar::FIELD_HOUR_OF_DAY);
        $eid_al_hajj_cal->clear(IntlCalendar::FIELD_MINUTE);
        $eid_al_hajj_cal->clear(IntlCalendar::FIELD_SECOND);
        $eid_al_hajj_cal->clear(IntlCalendar::FIELD_MILLISECOND);

        // Eid-e-Milad an-Nabi (Mawlid) is on the 12th day of  the 3rd month in the calendar
        // since the PHP array index begins at 0, it is the 11th month
        $mawlid_cal = IntlCalendar::createInstance('Africa/Dar_es_Salaam', '@calendar=islamic-civil');
        $mawlid_cal->set(IntlCalendar::FIELD_MONTH, 2);
        $mawlid_cal->set(IntlCalendar::FIELD_DAY_OF_MONTH, 12);
        $mawlid_cal->clear(IntlCalendar::FIELD_HOUR_OF_DAY);
        $mawlid_cal->clear(IntlCalendar::FIELD_MINUTE);
        $mawlid_cal->clear(IntlCalendar::FIELD_SECOND);
        $mawlid_cal->clear(IntlCalendar::FIELD_MILLISECOND);

        $variable_holidays = [
            'Easter Monday' => $easter->addDay(),
            'Good Friday' => $easter->addDays(-2),
            'Eid al-Fitr' => CarbonImmutable::createFromTimestamp($eid_al_fitr_cal->toDateTime()->getTimestamp()),
            'Eid al-Hajj' => CarbonImmutable::createFromTimestamp($eid_al_hajj_cal->toDateTime()->getTimestamp()),
            'Maulid Day' => CarbonImmutable::createFromTimestamp($mawlid_cal->toDateTime()->getTimestamp()),
        ];

        // Zanzibar Revolutionary Day celebrations started in 1964
        if ($year >= 1964) {
            $variable_holidays['Zanzibar Revolutionary Day'] = '01-12';
        }

        // Karume Day celebrations started in 1973
        if ($year >= 1973) {
            $variable_holidays['Karume Day'] = '04-07';
        }

        //  'Union Day celebrations started in 1964
        if ($year >= 1964) {
            $variable_holidays['Union Day'] = '04-26';
        }

        // Nyerere Day day celebrations started in 2000
        if ($year >= 2000) {
            $variable_holidays['Nyerere Day'] = '10-14';
        }

        // Independence Day celebrations started in 1961
        if ($year >= 1961) {
            $variable_holidays['Independence Day'] = '12-09';
        }

        return $variable_holidays;
    }
}
