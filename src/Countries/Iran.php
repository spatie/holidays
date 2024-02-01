<?php

namespace Spatie\Holidays\Countries;

class Iran extends Country
{
    public function countryCode(): string
    {
        return 'ir';
    }

    protected function allHolidays(int $year): array
    {
        return [
            'پیروزی انقلاب اسلامی پنجاه و هفت' => '02-11',
            'روز ملی شدن صنعت نفت' => '03-19',
            'نخستین روز نوروز' => '03-20',
            'دومین روز نوروز' => '03-21',
            'سومین روز نوروز' => '03-22',
            'چهارمین روز نوروز' => '03-23',
            'روز جمهوری اسلامی' => '03-31',
            'سیزده بدر' => '04-01',
            'رحلت روح‌الله خمینی' => '06-03',
            'قیام ۱۵ خرداد' => '06-04',
        ];
    }
}
