<?php

namespace Spatie\Holidays\Tests;

use Spatie\Holidays\Countries\Belgium;

it('can calculate orthodox easter', function (int $year, string $date) {
    $country = Belgium::make();

    $easter = invade($country)->orthodoxEaster($year);

    expect($easter->format('Y-m-d'))->toBe($date);
})->with([
    [1997, '1997-04-27'],
    [1998, '1998-04-19'],
    [1999, '1999-04-11'],
    [2000, '2000-04-30'],
    [2001, '2001-04-15'],
    [2002, '2002-05-05'],
    [2003, '2003-04-27'],
    [2004, '2004-04-11'],
    [2005, '2005-05-01'],
    [2006, '2006-04-23'],
    [2007, '2007-04-08'],
    [2008, '2008-04-27'],
    [2009, '2009-04-19'],
    [2010, '2010-04-04'],
    [2011, '2011-04-24'],
    [2012, '2012-04-15'],
    [2013, '2013-05-05'],
    [2014, '2014-04-20'],
    [2015, '2015-04-12'],
    [2016, '2016-05-01'],
    [2017, '2017-04-16'],
    [2018, '2018-04-08'],
    [2019, '2019-04-28'],
    [2020, '2020-04-19'],
    [2021, '2021-05-02'],
    [2022, '2022-04-24'],
    [2023, '2023-04-16'],
    [2024, '2024-05-05'],
    [2025, '2025-04-20'],
    [2026, '2026-04-12'],
    [2027, '2027-05-02'],
    [2028, '2028-04-16'],
    [2029, '2029-04-08'],
]);
