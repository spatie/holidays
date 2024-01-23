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
            'Πρωτοχρονιά' => '01-01',
            'Θεοφάνια' => '01-06',
            '25η Μαρτίου' => '03-25',
            'Πρωτομαγιά' => '05-01',
            'Δεκαπενταύγουστος' => '08-15',
            '28η Οκτωβρίου' => '10-28',
            'Χριστούγεννα' => '12-25',
            'Σύναξη της Θεοτόκου' => '12-26',

        ], $this->variableHolidays($year));
    }

    /** @return array<string, CarbonImmutable> */
    protected function variableHolidays(int $year): array
    {
        // OrthodoxEaster needs to setTimezone
        $orthodoxEaster = $this->orthodoxEaster($year)->setTimezone('Europe/Athens');
        $cleanMonday = $orthodoxEaster->copy()->subDays(48);
        $megaliParaskevi = $orthodoxEaster->copy()->subDays(2);
        $megaloSavvato = $orthodoxEaster->copy()->subDays(1);
        $deuteraPasha = $orthodoxEaster->copy()->addDay();
        $agiouPneumatos = $orthodoxEaster->copy()->addDays(50);

        /** @var CarbonImmutable $protomagia */
        $protomagia = CarbonImmutable::createFromFormat('Y-m-d', "{$year}-05-01");
        $moveProtomagia = [$megaliParaskevi, $megaloSavvato, $orthodoxEaster, $deuteraPasha];

        if (in_array($protomagia, $moveProtomagia)) {
            $protomagia = $orthodoxEaster->copy()->addDays(2);
        }
        if ($protomagia->isSunday()) {
            $protomagia = $protomagia->copy()->addDay();
        }

        return [
            'Καθαρά Δευτέρα' => $cleanMonday, //always Monday
            'Πρωτομαγιά' => $protomagia,
            'Μεγάλη Παρασκευή' => $megaliParaskevi,
            'Κυριακή του Πάσχα' => $orthodoxEaster,
            'Δευτέρα του Πάσχα' => $deuteraPasha,
            'Αγίου Πνεύματος' => $agiouPneumatos, //always Monday
        ];
    }
}
