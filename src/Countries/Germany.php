<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Germany extends Country
{
    protected function __construct(
        protected ?string $region = null,
    ) {
    }

    public function countryCode(): string
    {
        return 'de';
    }

    private function getRepentanceAndPrayerDay(int $year): string
    {
        $repentanceAndPrayerDay = new CarbonImmutable('next wednesday '.$year.'-11-15', 'Europe/Berlin');

        return $repentanceAndPrayerDay->format('m-d');
    }

    /** @return array<string, string> */
    protected function historicalHolidays(int $year): array
    {
        $historicalHolidays = [];
        if ($year >= 1990 && $year <= 1994) {
            $historicalHolidays['Buß- und Bettag'] = $this->getRepentanceAndPrayerDay($year);
        }
        if ($year === 2017) {
            $historicalHolidays['Reformationstag'] = '10-31';
        }

        return $historicalHolidays;
    }

    /** @return array<string, CarbonImmutable|string> */
    protected function allHolidays(int $year): array
    {

        return array_merge([
            'Neujahr' => '01-01',
            'Tag der deutschen Einheit' => '10-03',
            'Tag der Arbeit' => '05-01',
            '1. Weihnachtstag' => '12-25',
            '2. Weihnachtstag' => '12-26',
        ], $this->variableHolidays($year), $this->historicalHolidays($year), $this->regionHolidays($year));
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

    /** @return array<string, CarbonImmutable|string> */
    protected function regionHolidays(int $year): array
    {
        $easter = $this->easter($year);

        switch ($this->region) {
            case 'DE-BW':
                return [
                    'Heilige Drei Könige' => '01-06',
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => '11-01',
                ];
            case 'DE-BY':
                return [
                    'Heilige Drei Könige' => '01-06',
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => '11-01',
                    'Mariä Himmelfahrt' => '08-15',
                ];

            case 'DE-BE':
                if ($year >= 2019) {
                    return [
                        'Internationaler Frauentag' => '03-08',
                    ];
                } else {
                    return [

                    ];
                }
            case 'DE-BB':
                if ($year >= 1991) {
                    return [
                        'Ostersonntag' => $easter,
                        'Reformationstag' => '10-31',
                        'Pfingstsonntag' => $easter->addDays(49),
                    ];
                } else {
                    return [
                        'Ostersonntag' => $easter,
                        'Pfingstsonntag' => $easter->addDays(49),
                    ];
                }
            case 'DE-HB':
            case 'DE-HH':
            case 'DE-NI':
            case 'DE-SH':
                if ($year >= 2017) {
                    return [
                        'Reformationstag' => '10-31',
                    ];
                } else {
                    return [

                    ];
                }

            case 'DE-HE':
                return [
                    'Ostersonntag' => $easter,
                    'Pfingstsonntag' => $easter->addDays(49),
                    'Fronleichnam' => $easter->addDays(60),
                ];
            case 'DE-MV':
                $mvHolidays = [];
                if ($year >= 1990) {
                    $mvHolidays['Reformationstag'] = '10-31';
                }
                if ($year >= 2023) {
                    $mvHolidays['Internationaler Frauentag'] = '03-08';
                }

                return $mvHolidays;
            case 'DE-NW':
            case 'DE-RP':

                return [
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => '11-01',
                ];
            case 'DE-SL':
                return [
                    'Fronleichnam' => $easter->addDays(60),
                    'Allerheiligen' => '11-01',
                    'Mariä Himmelfahrt' => '08-15',
                ];
            case 'DE-SN':
                $snHolidays = [];
                if ($year >= 1990) {
                    $snHolidays['Reformationstag'] = '10-31';

                }
                if ($year > 1994) {
                    $snHolidays['Buß- und Bettag'] = $this->getRepentanceAndPrayerDay($year);

                }

                return $snHolidays;
            case 'DE-ST':
                $stHolidays = [];
                if ($year >= 1990) {
                    $stHolidays['Reformationstag'] = '10-31';

                }
                if ($year >= 1991) {
                    $stHolidays['Heilige Drei Könige'] = '01-06';
                }
            case 'DE-TH':
                $thHolidays = [];
                if ($year >= 1990) {
                    $thHolidays['Reformationstag'] = '10-31';
                }
                if ($year >= 2019) {
                    $thHolidays['Weltkindertag'] = '09-20';
                }

                return $thHolidays;

        }

        return [];
    }
}
