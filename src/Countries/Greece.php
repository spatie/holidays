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

        $orthodox_easter = $this->orthodoxEaster($year);
        $protomagia = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-05-01");

        if (
            $protomagia == $orthodox_easter->subDays(2) ||
            $protomagia == $orthodox_easter->subDays(1) ||
            $protomagia == $orthodox_easter ||
            $protomagia == $orthodox_easter->addDay()
        ) {
            $protomagia = $orthodox_easter->addDays(2);
        }
        if ($protomagia->isSunday()) {
            $protomagia = $protomagia->addDay();
        }

        return [
            'Καθαρά Δευτέρα'    => $orthodox_easter->subDays(48), //always Monday
            'Πρωτομαγιά'        => $protomagia,
            'Μεγάλη Παρασκευή'  => $orthodox_easter->subDays(2),
            'Κυριακή του Πάσχα' => $orthodox_easter,
            'Δευτέρα του Πάσχα' => $orthodox_easter->addDay(),
            'Αγίου Πνεύματος'   => $orthodox_easter->addDays(50), //always Monday
        ];
    }
}