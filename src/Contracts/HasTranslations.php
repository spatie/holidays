<?php

namespace Spatie\Holidays\Contracts;

interface HasTranslations
{
    public function defaultLocale(): string;

    public function translate(string $country, string $name, ?string $locale = null): string;
}
