<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Calendars\IslamicCalendar;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;
use Spatie\Holidays\Contracts\Islamic;
use Spatie\Holidays\Exceptions\InvalidYear;

class Egypt extends Country implements HasTranslations, Islamic
{
    use IslamicCalendar;
    use Translatable;

    protected const eidAlFitr = [
        2005 => '11-04',
        2006 => '10-24',
        2007 => '10-13',
        2008 => '10-02',
        2009 => '09-21',
        2010 => '09-10',
        2011 => '08-30',
        2012 => '08-19',
        2013 => '08-08',
        2014 => '07-28',
        2015 => '07-17',
        2016 => '07-07',
        2017 => '06-26',
        2018 => '06-15',
        2019 => '06-05',
        2020 => '05-24',
        2021 => '05-13',
        2022 => '05-02',
        2023 => '04-20',
        2024 => '04-10',
        2025 => '03-31',
        2026 => '03-21',
        2027 => '03-10',
        2028 => '02-27',
        2029 => '02-15',
        2030 => '02-04',
        2031 => '01-25',
        2032 => '01-15',
        2033 => '01-03',
        2034 => '12-13',
        2035 => '12-02',
        2036 => '11-20',
        2037 => '11-09',
    ];

    protected const arafat = [
        2005 => '01-21',
        2006 => '01-10',
        2007 => '01-01',
        2008 => '12-09',
        2009 => '11-26',
        2010 => '11-15',
        2011 => '11-05',
        2012 => '10-25',
        2013 => '10-15',
        2014 => '10-04',
        2015 => '09-23',
        2016 => '09-11',
        2017 => '08-31',
        2018 => '08-20',
        2019 => '08-10',
        2020 => '07-30',
        2021 => '07-19',
        2022 => '07-09',
        2023 => '06-27',
        2024 => '06-16',
        2025 => '06-06',
        2026 => '05-26',
        2027 => '05-16',
        2028 => '05-05',
        2029 => '04-24',
        2030 => '04-13',
        2031 => '04-02',
        2032 => '03-21',
        2033 => '03-11',
        2034 => '03-01',
        2035 => '02-18',
        2036 => '02-07',
        2037 => '01-26',
    ];

    protected const eidAlAdha = [
        2005 => '01-22',
        2006 => '01-11',
        2007 => '01-02',
        2008 => '12-10',
        2009 => '11-27',
        2010 => '11-16',
        2011 => '11-06',
        2012 => '10-26',
        2013 => '10-16',
        2014 => '10-05',
        2015 => '09-24',
        2016 => '09-12',
        2017 => '08-31',
        2018 => '08-21',
        2019 => '08-11',
        2020 => '07-31',
        2021 => '07-20',
        2022 => '07-09',
        2023 => '06-28',
        2024 => '06-17',
        2025 => '06-07',
        2026 => '05-27',
        2027 => '05-17',
        2028 => '05-06',
        2029 => '04-25',
        2030 => '04-14',
        2031 => '04-03',
        2032 => '03-22',
        2033 => '03-12',
        2034 => '03-02',
        2035 => '02-19',
        2036 => '02-08',
        2037 => '01-27',
    ];

    protected const islamicNewYear = [
        2005 => '02-10',
        2006 => '01-31',
        2007 => '01-20',
        2008 => '01-10',
        2009 => '12-18',
        2010 => '12-07',
        2011 => '11-27',
        2012 => '11-15',
        2013 => '11-05',
        2014 => '10-25',
        2015 => '10-14',
        2016 => '10-03',
        2017 => '09-22',
        2018 => '09-11',
        2019 => '08-31',
        2020 => '08-20',
        2021 => '08-09',
        2022 => '07-30',
        2023 => '07-19',
        2024 => '07-08',
        2025 => '06-06',
        2026 => '06-17',
        2027 => '06-07',
        2028 => '05-26',
        2029 => '05-15',
        2030 => '05-05',
        2031 => '04-24',
        2032 => '04-12',
        2033 => '04-01',
        2034 => '03-22',
        2035 => '03-12',
        2036 => '02-29',
        2037 => '02-17',
    ];

    protected const ashura = [
        2005 => '02-19',
        2006 => '02-09',
        2007 => '01-29',
        2008 => '01-19',
        2009 => '12-27',
        2010 => '12-16',
        2011 => '12-06',
        2012 => '11-25',
        2013 => '11-15',
        2014 => '11-04',
        2015 => '10-24',
        2016 => '10-13',
        2017 => '10-02',
        2018 => '09-21',
        2019 => '09-10',
        2020 => '08-30',
        2021 => '08-19',
        2022 => '08-08',
        2023 => '07-28',
        2024 => '07-17',
        2025 => '07-07',
        2026 => '06-26',
        2027 => '06-15',
        2028 => '06-04',
        2029 => '05-24',
        2030 => '05-13',
        2031 => '05-02',
        2032 => '04-20',
        2033 => '04-10',
        2034 => '03-30',
        2035 => '03-19',
        2036 => '03-08',
        2037 => '02-25',
    ];

    protected const prophetMuhammadBirthday = [
        2005 => '04-21',
        2006 => '04-11',
        2007 => '03-31',
        2008 => '03-20',
        2009 => '03-09',
        2010 => '02-26',
        2011 => '02-16',
        2012 => '02-05',
        2013 => '01-24',
        2014 => '01-13',
        2015 => '12-23',
        2016 => '12-12',
        2017 => '12-01',
        2018 => '11-20',
        2019 => '11-09',
        2020 => '10-29',
        2021 => '10-21',
        2022 => '10-08',
        2023 => '09-28',
        2024 => '09-16',
        2025 => '09-06',
        2026 => '08-26',
        2027 => '08-15',
        2028 => '08-04',
        2029 => '07-25',
        2030 => '07-14',
        2031 => '07-03',
        2032 => '06-21',
        2033 => '06-10',
        2034 => '05-31',
        2035 => '05-21',
        2036 => '05-09',
        2037 => '04-29',
    ];

    public function countryCode(): string
    {
        return 'eg';
    }

    public function defaultLocale(): string
    {
        return 'en';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s Day' => '1-1',
            'Flooding of the Nile' => '8-15',
            'March Equinox' => '3-20',
            'June Solstice' => '6-21',
            'Nayrouz' => '9-11',
            'September Equinox' => '9-22',
            'December Solstice' => '12-21',
        ],
            $this->fixedHolidays($year),
            $this->variableHolidays($year),
            $this->islamicHolidays($year),
        );
    }

    /** @return array<string, CarbonInterface> */
    protected function variableHolidays(int $year): array
    {
        $orthodoxEaster = $this->orthodoxEaster($year);

        return [
            'Coptic Good Friday' => $orthodoxEaster->subDays(2)->toImmutable(),
            'Coptic Holy Saturday' => $orthodoxEaster->subDays()->toImmutable(),
            'Coptic Easter Sunday' => $orthodoxEaster->toImmutable(),
        ];
    }

    /**
     * @return array<string, CarbonInterface>
     */
    private function fixedHolidays(int $year): array
    {
        $holidays = [
            'Coptic Christmas Day' => CarbonImmutable::createFromDate($year, 1, 7),
            'Revolution Day 2011' => CarbonImmutable::createFromDate($year, 1, 25),
            'Sinai Liberation Day' => CarbonImmutable::createFromDate($year, 4, 25),
            'Labour Day' => CarbonImmutable::createFromDate($year, 5, 1),
            'June 30 Revolution Day' => CarbonImmutable::createFromDate($year, 6, 30),
            'Revolution Day' => CarbonImmutable::createFromDate($year, 7, 23),
            'Armed Forces Day' => CarbonImmutable::createFromDate($year, 10, 6),
            'Spring Festival' => $this->orthodoxEaster($year)->addDay()->toImmutable(),
        ];

        foreach ($holidays as $name => $date) {
            $holidays = array_merge($holidays, $this->adjustForWeekend($name, $date));
        }

        return $holidays;
    }

    public function islamicHolidays(int $year): array
    {
        /**
         * No reliable sources exist for Islamic holidays observed in Egypt prior to 2005.
         * So we'll only calculate holidays from 2005 onwards.
         *
         * @see https://www.timeanddate.com/holidays/egypt
         */
        if ($year < 2005) {
            throw InvalidYear::yearTooLow(2005);
        }

        $eidAlFitr = $this->eidAlFitr($year);
        $eidAlAdha = $this->eidAlAdha($year);
        $ashura = $this->ashura($year, 1);

        return array_merge(
            [
                'Arafat Day' => $this->arafat($year),
                'Islamic New Year' => $this->islamicNewYear($year),
                'Birthday of the Prophet Muhammad' => $this->prophetMuhammadBirthday($year),
            ],
            $this->convertPeriods('Eid al-Adha', $year, $eidAlAdha[0]),
            $this->convertPeriods('Eid al-Fitr', $year, $eidAlFitr[0]),
            $this->convertPeriods('Ashura', $year, $ashura[0]),
        );
    }

    /** @return array<string, CarbonInterface> */
    private function adjustForWeekend(string $name, CarbonImmutable $date): array
    {
        $adjustedHolidays = [];

        // Explicitly define this logic to avoid timezone confusion on the CarbonInterface::next() method
        if ($date->isFriday() || $date->isSaturday()) {
            // If the holiday falls on a weekend (Friday or Saturday), it is observed on the following Sunday
            $adjustedHolidays['Day off for '.$name] = $date->next(CarbonInterface::SUNDAY);
        } elseif ($date->isSunday() || $date->isThursday()) {
            // If the holiday falls on a Sunday or Thursday, it is observed on the same day
            $adjustedHolidays[$name] = $date;
        } else {
            // If the holiday falls on a weekday (Monday, Tuesday, Wednesday), it is observed on the following Thursday
            $adjustedHolidays['Day off for '.$name] = $date->next(CarbonInterface::THURSDAY);
        }

        return $adjustedHolidays;
    }
}
