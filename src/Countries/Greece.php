<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Greece extends Country
{
    public function countryCode(): string
    {
        return 'el';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Πρωτοχρονιά'         => '01-01',
            'Θεοφάνια'            => '01-06',
            '25η Μαρτίου'         => '03-25',
            'Πρωτομαγιά'          => '05-01',
            'Δεκαπενταύγουστος'   => '08-15',
            '28η Οκτωβρίου'       => '10-28',
            'Χριστούγεννα'        => '12-25',
            'Σύναξη της Θεοτόκου' => '12-26',

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {

        $orthodoxEaster = $this->orthodoxEaster($year);
        /** @var CarbonImmutable $protomagia */
        $protomagia = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-05-01");

        if (
            $protomagia == $orthodoxEaster->subDays(2) ||
            $protomagia == $orthodoxEaster->subDays(1) ||
            $protomagia == $orthodoxEaster ||
            $protomagia == $orthodoxEaster->addDay()
        ) {
            $protomagia = $orthodoxEaster->addDays(2);
        }
        if ($protomagia->isSunday()) {
            $protomagia = $protomagia->addDay();
        }

        return [
            'Καθαρά Δευτέρα'    => $orthodoxEaster->subDays(48), //always Monday
            'Πρωτομαγιά'        => $protomagia,
            'Μεγάλη Παρασκευή'  => $orthodoxEaster->subDays(2),
            'Κυριακή του Πάσχα' => $orthodoxEaster,
            'Δευτέρα του Πάσχα' => $orthodoxEaster->addDay(),
            'Αγίου Πνεύματος'   => $orthodoxEaster->addDays(50), //always Monday
        ];
    }
}