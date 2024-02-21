<?php

namespace Spatie\Holidays\Concerns;

use Spatie\Holidays\Exceptions\InvalidLocale;

trait Translatable
{
    public function translate(string $country, string $name, ?string $locale = null): string
    {
        if ($locale === $this->defaultLocale()) {
            return $name;
        }

        $locale = $locale ?? $this->defaultLocale();

        $countryName = strtolower($country);
        $filePath = __DIR__."/../../lang/{$countryName}/{$locale}/holidays.json";

        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
        } else {
            return $name;
        }

        if ($content === false) {
            throw InvalidLocale::notFound($country, $locale);
        }

        /** @var array<string, string> $data */
        $data = json_decode($content, true);

        return $data[$name] ?? $name;
    }
}
