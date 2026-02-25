<?php

use Spatie\Holidays\CountryRegistry;

arch('it will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

it('has all country classes registered in CountryRegistry', function () {
    $registeredClasses = array_values(CountryRegistry::all());

    $countryFiles = glob(__DIR__.'/../src/Countries/*.php');
    $missingCountries = [];

    foreach ($countryFiles as $file) {
        $className = basename($file, '.php');

        if ($className === 'Country') {
            continue;
        }

        $fqcn = "Spatie\\Holidays\\Countries\\{$className}";

        if (! in_array($fqcn, $registeredClasses, true)) {
            $missingCountries[] = $className;
        }
    }

    expect($missingCountries)
        ->toBeEmpty(
            'The following countries are missing from CountryRegistry: '.implode(', ', $missingCountries)
        );
});
