<?php

namespace Spatie\Holidays\Concerns;

/** @ */
trait Translatable
{
    protected function translate(string $country, string $name, ?string $locale = null): string
    {
        if ($locale === null) {
            return $name;
        }

        $countryName = strtolower($country);

        $content = file_get_contents(__DIR__ . "/../../lang/{$countryName}/{$locale}/holidays.json");

        if ($content === false) {
            return $name;
        }

        $data = json_decode($content, true);

        if (! isset($data[$name])) {
            return $name;
        }

        return $data[$name];
    }
}
