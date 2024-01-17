<?php

namespace Spatie\Holidays\Tests\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate myanmar holidays', function () {

    $result = Holidays::for('mm')->getName(CarbonImmutable::parse('2024-12-25'));

    expect($result)->toBe('ခရစ်စမတ်နေ့');


    $result = Holidays::for('mm')->getName(CarbonImmutable::parse('2024-01-02'));
    expect($result)->toBeNull();
});
