<?php

use Spatie\Holidays\Contracts\HasRegions;
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

it('countries with a $region constructor param implement HasRegions', function () {
    $countryFiles = glob(__DIR__.'/../src/Countries/*.php');
    $missingInterface = [];

    foreach ($countryFiles as $file) {
        $className = basename($file, '.php');

        if ($className === 'Country') {
            continue;
        }

        $fqcn = "Spatie\\Holidays\\Countries\\{$className}";
        $reflection = new ReflectionClass($fqcn);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            continue;
        }

        foreach ($constructor->getParameters() as $param) {
            if ($param->getName() === 'region' && ! $reflection->implementsInterface(HasRegions::class)) {
                $missingInterface[] = $className;
            }
        }
    }

    expect($missingInterface)
        ->toBeEmpty(
            'Countries with $region param must implement HasRegions: '.implode(', ', $missingInterface)
        );
});
