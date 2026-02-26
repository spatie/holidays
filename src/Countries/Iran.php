<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Iran extends Country
{
    public function countryCode(): string
    {
        return 'ir';
    }

    protected function defaultLocale(): string
    {
        return 'fa';
    }

    protected function allHolidays(int $year): array
    {
        return [
            Holiday::national('پیروزی انقلاب اسلامی پنجاه و هفت', "{$year}-02-11"),
            Holiday::national('روز ملی شدن صنعت نفت', "{$year}-03-19"),
            Holiday::national('نخستین روز نوروز', "{$year}-03-20"),
            Holiday::national('دومین روز نوروز', "{$year}-03-21"),
            Holiday::national('سومین روز نوروز', "{$year}-03-22"),
            Holiday::national('چهارمین روز نوروز', "{$year}-03-23"),
            Holiday::national('روز جمهوری اسلامی', "{$year}-03-31"),
            Holiday::national('سیزده بدر', "{$year}-04-01"),
            Holiday::national('رحلت روح‌الله خمینی', "{$year}-06-03"),
            Holiday::national('قیام ۱۵ خرداد', "{$year}-06-04"),
        ];
    }
}
