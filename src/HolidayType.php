<?php

namespace Spatie\Holidays;

enum HolidayType: string
{
    case National = 'national';
    case Regional = 'regional';
    case Observed = 'observed';
    case Religious = 'religious';
    case Bank = 'bank';
}
