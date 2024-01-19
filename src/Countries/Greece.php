<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Greece extends Country
{
    public function countryCode(): string
    {
        return 'el';
    }

    /** @return array<string, string|CarbonImmutable> */
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

        $orthodox_easter = CarbonImmutable::createFromTimestamp(
            $this->calculateOrthodoxEaster($year)
        )->setTimezone("Europe/Athens");


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

    /** @return string */
    protected function calculateOrthodoxEaster(int $year)
    {
      $a = $year % 4;
      $b = $year % 7;
      $c = $year % 19;
      $d = (19 * $c + 15) % 30;
      $e = (2 * $a + 4 * $b - $d + 34) % 7;
      $month = (int) (($d + $e + 114) / 31);
      $day = (($d + $e + 114) % 31) + 1;
      // julian to gregorian
      $jtg = (int) ($year / 100) - (int) ($year / 400) - 2;

      $easterDate = mktime(0, 0, 0, $month, $day + $jtg, $year);

      return $easterDate;
    }
}