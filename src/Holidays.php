<?php

namespace Spatie\Holidays;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Spatie\Holidays\Countries\Country;

class Holidays
{
    /** @var array<Holiday> */
    protected array $holidays = [];

    protected function __construct(
        protected Country $country,
        protected int $year,
        protected ?string $locale = null,
        protected ?CarbonImmutable $from = null,
        protected ?CarbonImmutable $to = null,
    ) {}

    public static function for(Country|string $country, ?int $year = null, ?string $locale = null, ?string $region = null): static
    {
        $year ??= CarbonImmutable::now()->year;

        if (is_string($country)) {
            $country = Country::findOrFail($country, $region);
        }

        return new static($country, $year, $locale);
    }

    public static function has(string $country): bool
    {
        return Country::find($country) !== null;
    }

    /** @return array<Holiday> */
    public function get(?HolidayType $type = null): array
    {
        $holidays = $this->calculate()->holidays;

        return $this->filterByType($holidays, $type);
    }

    /**
     * getInRange method allows you to pick holidays in a range of dates,
     *   - dates are inclusive.
     *   - dates are swappable, lower date could be passed as second argument.
     *   - dates could be a CarbonInterface or a string.
     *   - acceptable strings formats are 'Y-m-d' or 'Y-m' or 'Y'
     *   - if passed string is 'Y-m' or 'Y' it will be converted to first(from) / last{to} day of the month(from) / year(to)
     * E.g. to retrieve all holidays in between
     *    - 2020-01-01 and 2024-12-31, you could use: getInRange('2020-01-01', '2024-12-31'), getInRange('2020-01', '2024-12') or getInRange('2020', '2024')
     *    - 2024-06-01 and 2025-05-30, you could use: getInRange('2024-06-01', '2025-05-30'), getInRange('2024-06', '2025-05')
     *
     * @return array<Holiday>
     */
    public function getInRange(CarbonInterface|string $from, CarbonInterface|string $to, ?HolidayType $type = null): array
    {
        [$from, $to] = $this->normalizeRange($from, $to);

        $holidays = $this->holidaysBetween($from, $to);

        $holidays = $this->sortHolidays($holidays);

        return $this->filterByType($holidays, $type);
    }

    /**
     * @return array<Holiday>
     */
    public function getUpcoming(int $count = 3): array
    {
        $today = CarbonImmutable::today();
        $holidays = [];
        $year = $today->year;

        while (count($holidays) < $count) {
            $yearHolidays = $this->holidaysForYear($year);

            foreach ($yearHolidays as $holiday) {
                if ($holiday->date->gte($today)) {
                    $holidays[] = $holiday;
                }

                if (count($holidays) >= $count) {
                    break;
                }
            }

            $year++;
        }

        return $this->sortHolidays($holidays);
    }

    /**
     * @return array<LongWeekend>
     */
    public function getLongWeekends(int $minimumDays = 4): array
    {
        $year = $this->year;
        $holidays = $this->holidaysForYear($year);
        $holidays = $this->sortHolidays($holidays);

        $longWeekends = [];
        $currentGroup = null;

        foreach ($holidays as $holiday) {
            if ($currentGroup === null) {
                $currentGroup = [$holiday];

                continue;
            }

            $lastHoliday = end($currentGroup);
            $daysBetween = $lastHoliday->date->diffInDays($holiday->date);

            if ($daysBetween <= $minimumDays) {
                $currentGroup[] = $holiday;
            } else {
                $longWeekend = $this->createLongWeekend($currentGroup, $minimumDays);
                if ($longWeekend) {
                    $longWeekends[] = $longWeekend;
                }
                $currentGroup = [$holiday];
            }
        }

        if ($currentGroup !== null) {
            $longWeekend = $this->createLongWeekend($currentGroup, $minimumDays);
            if ($longWeekend) {
                $longWeekends[] = $longWeekend;
            }
        }

        return $longWeekends;
    }

    /**
     * @param  array<Holiday>  $holidays
     */
    private function createLongWeekend(array $holidays, int $minimumDays): ?LongWeekend
    {
        if (count($holidays) < 2) {
            return null;
        }

        /** @var Holiday $first */
        $first = $holidays[0];
        $startDate = $first->date;
        $endDate = end($holidays)->date;
        $dayCount = (int) $startDate->diffInDays($endDate) + 1;

        if ($dayCount < $minimumDays) {
            return null;
        }

        return new LongWeekend($startDate, $endDate, $dayCount, $holidays);
    }

    /**
     * @return array{CarbonImmutable, CarbonImmutable}
     */
    private function normalizeRange(CarbonInterface|string $from, CarbonInterface|string $to): array
    {
        if (! $from instanceof CarbonImmutable) {
            $from = match (strlen($from)) {
                4 => CarbonImmutable::parse("{$from}-01-01"),
                7 => CarbonImmutable::parse("{$from}-01"),
                default => CarbonImmutable::parse($from),
            };
        }

        if (! $to instanceof CarbonImmutable) {
            $to = match (strlen($to)) {
                4 => CarbonImmutable::parse("{$to}-12-31"),
                7 => CarbonImmutable::parse($to)->endOfMonth(),
                default => CarbonImmutable::parse($to),
            };
        }

        if ($from->gt($to)) {
            [$from, $to] = [$to, $from];
        }

        return [$from, $to];
    }

    /** @return array<Holiday> */
    private function holidaysForYear(int $year): array
    {
        return $this->country->get($year, $this->locale);
    }

    /** @return array<Holiday> */
    private function holidaysBetween(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $holidays = [];

        for ($year = $from->year; $year <= $to->year; $year++) {
            foreach ($this->holidaysForYear($year) as $holiday) {
                if ($holiday->date->between($from, $to)) {
                    $holidays[] = $holiday;
                }
            }
        }

        return $holidays;
    }

    /**
     * @param  array<Holiday>  $holidays
     * @return array<Holiday>
     */
    private function sortHolidays(array $holidays): array
    {
        usort($holidays, static fn (Holiday $a, Holiday $b): int => $a->date->timestamp <=> $b->date->timestamp);

        return $holidays;
    }

    public function isHoliday(CarbonInterface|string $date): bool
    {
        $date = $this->normalizeDate($date);

        $holidays = static::for($this->country, $date->year, $this->locale)
            ->calculate()
            ->holidays;

        foreach ($holidays as $holiday) {
            if ($holiday->date->isSameDay($date)) {
                return true;
            }
        }

        return false;
    }

    public function isTodayHoliday(): bool
    {
        return $this->isHoliday(CarbonImmutable::today());
    }

    public function getName(CarbonInterface|string $date): ?string
    {
        $date = $this->normalizeDate($date);

        $holidays = static::for($this->country, $date->year, $this->locale)
            ->calculate()
            ->holidays;

        foreach ($holidays as $holiday) {
            if ($holiday->date->isSameDay($date)) {
                return $holiday->name;
            }
        }

        return null;
    }

    protected function calculate(): self
    {
        $this->holidays = $this->country->get($this->year, $this->locale);

        return $this;
    }

    private function normalizeDate(CarbonInterface|string $date): CarbonImmutable
    {
        if ($date instanceof CarbonImmutable) {
            return $date;
        }

        if ($date instanceof CarbonInterface) {
            return CarbonImmutable::instance($date);
        }

        return CarbonImmutable::parse($date);
    }

    /**
     * @param  array<Holiday>  $holidays
     * @return array<Holiday>
     */
    private function filterByType(array $holidays, ?HolidayType $type): array
    {
        if ($type === null) {
            return $holidays;
        }

        return array_values(array_filter(
            $holidays,
            static fn (Holiday $holiday): bool => $holiday->type === $type,
        ));
    }
}
