<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;
use Spatie\Holidays\Concerns\Translatable;
use Spatie\Holidays\Contracts\HasTranslations;

class Iran extends Country implements HasTranslations
{
    use Translatable;

    public function countryCode(): string
    {
        return 'ir';
    }

    public function defaultLocale(): string
    {
        return 'fa';
    }

    protected function allHolidays(int $year): array
    {
        return [
            'پیروزی انقلاب اسلامی پنجاه و هفت' => CarbonImmutable::createFromDate($year, 2, 11),
            'روز ملی شدن صنعت نفت' => CarbonImmutable::createFromDate($year, 3, 19),
            'نخستین روز نوروز' => CarbonImmutable::createFromDate($year, 3, 20),
            'دومین روز نوروز' => CarbonImmutable::createFromDate($year, 3, 21),
            'سومین روز نوروز' => CarbonImmutable::createFromDate($year, 3, 22),
            'چهارمین روز نوروز' => CarbonImmutable::createFromDate($year, 3, 23),
            'روز جمهوری اسلامی' => CarbonImmutable::createFromDate($year, 3, 31),
            'سیزده بدر' => CarbonImmutable::createFromDate($year, 4, 1),
            'رحلت روح‌الله خمینی' => CarbonImmutable::createFromDate($year, 6, 3),
            'قیام ۱۵ خرداد' => CarbonImmutable::createFromDate($year, 6, 4),
        ];
    }
}
