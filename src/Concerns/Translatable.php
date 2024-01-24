<?php

namespace Spatie\Holidays\Concerns;

use Spatie\Holidays\Exceptions\InvalidLocale;

trait Translatable
{
    protected function translate(string $country, string $name, ?string $locale = null): string
    {
        if ($locale === null) {
            return $name;
        }

        $countryName = strtolower($country);

        $content = file_get_contents(__DIR__."/../../lang/{$countryName}/{$locale}/holidays.json");

        if ($content === false) {
            throw InvalidLocale::notFound($country, $locale);
        }

        /** @var array<string, string> $data */
        $data = json_decode($content, true);

        if (! isset($data[$name])) {
            return $name;
        }

        return $data[$name];
    }
}
