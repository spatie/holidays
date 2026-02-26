<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holiday;

class Greece extends Country
{
    public function countryCode(): string
    {
        return 'el';
    }

    protected function allHolidays(int $year): array
    {
        return array_merge([
            Holiday::national('Πρωτοχρονιά', "{$year}-01-01"),
            Holiday::national('Θεοφάνια', "{$year}-01-06"),
            Holiday::national('25η Μαρτίου', "{$year}-03-25"),
            Holiday::national('Δεκαπενταύγουστος', "{$year}-08-15"),
            Holiday::national('28η Οκτωβρίου', "{$year}-10-28"),
            Holiday::national('Χριστούγεννα', "{$year}-12-25"),
            Holiday::national('Σύναξη της Θεοτόκου', "{$year}-12-26"),

        ], $this->variableHolidays($year));
    }

    /** @return array<Holiday> */
    protected function variableHolidays(int $year): array
    {

        $orthodoxEaster = $this->orthodoxEaster($year);
        $megaliTetarti = $orthodoxEaster->copy()->subDays(4);
        $megaliPempti = $orthodoxEaster->copy()->subDays(3);
        $megaliParaskevi = $orthodoxEaster->copy()->subDays(2);
        $megaloSavvato = $orthodoxEaster->copy()->subDay();
        $deuteraPasha = $orthodoxEaster->copy()->addDay();
        $protomagia = CarbonImmutable::createFromDate($year, 5, 1)->startOfDay();

        $moveProtomagia = [$megaliTetarti, $megaliPempti, $megaliParaskevi, $megaloSavvato, $orthodoxEaster, $deuteraPasha];
        if (in_array($protomagia, $moveProtomagia)) {
            $protomagia = $orthodoxEaster->copy()->addDays(2);
        }

        if ($protomagia->isSunday()) {
            $protomagia = $protomagia->copy()->addDay();
        }

        return [
            Holiday::national('Καθαρά Δευτέρα', $orthodoxEaster->copy()->subDays(48)),
            Holiday::national('Πρωτομαγιά', $protomagia),
            Holiday::national('Μεγάλη Παρασκευή', $megaliParaskevi),
            Holiday::national('Κυριακή του Πάσχα', $orthodoxEaster),
            Holiday::national('Δευτέρα του Πάσχα', $deuteraPasha),
            Holiday::national('Αγίου Πνεύματος', $orthodoxEaster->copy()->addDays(50)),
        ];
    }
}
