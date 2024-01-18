<?php

namespace Spati\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Holidays;

it('can calculate english holidays', function () {
  CarbonImmutable::setTestNowAndTimezone('2024-01-01');

  $holidays = Holidays::for(country: 'en')->get();

  expect($holidays)->toBeArray()->not()->toBeEmpty();

  expect(formatDates($holidays))->toMatchSnapshot();
});
