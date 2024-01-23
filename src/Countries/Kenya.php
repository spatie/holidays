<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 1/23/2024
 * @time: 9:08 PM
 */

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Kenya extends Country
{
    private string $timezone = 'Africa/Nairobi';

    public function countryCode(): string
    {
        return 'ke';
    }

    /**
     * @param int $year
     * @return CarbonImmutable[]
     */
    protected function allHolidays(int $year): array
    {
        return array_merge([
            'New Year\'s  Day' => new CarbonImmutable("{$year}-01-01", $this->timezone),
            'Labor Day' => new CarbonImmutable("{$year}-05-01", $this->timezone),
            'Madaraka Day' => new CarbonImmutable("{$year}-06-01", $this->timezone),
            'Huduma Day' => new CarbonImmutable("{$year}-10-10", $this->timezone),
            'Mashujaa Day' => new CarbonImmutable("{$year}-10-20", $this->timezone),
            'Jamuhuri Day' => new CarbonImmutable("{$year}-12-12", $this->timezone),
            'Christmas Day' => new CarbonImmutable("{$year}-12-25", $this->timezone),
            'Boxing Day' => new CarbonImmutable("{$year}-12-26", $this->timezone),
        ], $this->variableHolidays($year));
    }

    /**
     * @param int $year
     * @return array<string, CarbonImmutable>
     */
    protected function variableHolidays(int $year): array
    {
        $easter = CarbonImmutable::createFromTimestamp(easter_date($year), $this->timezone);
        return [
            'Good Friday' => $easter->subDays(2),
            'Easter Monday' => $easter->addDay(),
        ];
    }
}
