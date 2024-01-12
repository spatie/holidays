<?php

namespace Spatie\Holidays\Tests\Actions;

use Spatie\Holidays\Actions\Belgium;

it('can calculate belgian holidays', function () {
    $action = new Belgium();

    expect($action->execute(2023))->toMatchSnapshot();
});
