<?php

namespace Spatie\Holidays\Countries;

class Sudan extends Country
{
    public function countryCode(): string
    {
        return 'sd';
    }


    protected function allHolidays(int $year): array
    {
        return array_merge([
            'Independence Day' => '01-01',
            'International Workers Day' => '05-01'
        ], $this->variableHolidays($year));
    }


     /** @return array<string, CarbonImmutable> */
     protected function variableHolidays(int $year): array
     {
         $easter = $this->easter($year);
 
         return [
             'weekend' =>  $easter->subDays(2)
         ];
     }
}
