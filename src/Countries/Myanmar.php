<?php

namespace Spatie\Holidays\Countries;

use Carbon\CarbonImmutable;

class Myanmar extends Country
{
    public function countryCode(): string
    {
        return 'mm';
    }

    protected function allHolidays(int $year): array
    {
        return [
            'လွတ်လပ်ရေးနေ့' => CarbonImmutable::createFromDate($year, 1, 4),
            'ကရင်နှစ်သစ်ကူးနေ့' => CarbonImmutable::createFromDate($year, 1, 11),
            'ပြည်ထောင်စုနေ့' => CarbonImmutable::createFromDate($year, 2, 12),
            'တောင်သူလယ်သမားနေ့' => CarbonImmutable::createFromDate($year, 3, 2),
            'တပေါင်းလပြည့်နေ့' => CarbonImmutable::createFromDate($year, 3, 24),
            'တပ်မတော်နေ့' => CarbonImmutable::createFromDate($year, 3, 27),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၁' => CarbonImmutable::createFromDate($year, 4, 13),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၂' => CarbonImmutable::createFromDate($year, 4, 14),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၃' => CarbonImmutable::createFromDate($year, 4, 15),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၄' => CarbonImmutable::createFromDate($year, 4, 16),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၅' => CarbonImmutable::createFromDate($year, 4, 17),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၆' => CarbonImmutable::createFromDate($year, 4, 18),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၇' => CarbonImmutable::createFromDate($year, 4, 19),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၈' => CarbonImmutable::createFromDate($year, 4, 20),
            'မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၉' => CarbonImmutable::createFromDate($year, 4, 21),
            'အလုပ်သမားနေ့' => CarbonImmutable::createFromDate($year, 5, 1),
            'ကဆုန်လပြည့်နေ့' => CarbonImmutable::createFromDate($year, 5, 22),
            'အာဇာနည်နေ့' => CarbonImmutable::createFromDate($year, 7, 19),
            'ဝါဆိုလပြည့်နေ့' => CarbonImmutable::createFromDate($year, 7, 20),
            'သီတင်းကျွတ်ရုံးပိတ်ရက် ၁' => CarbonImmutable::createFromDate($year, 10, 16),
            'သီတင်းကျွတ်ရုံးပိတ်ရက် ၂' => CarbonImmutable::createFromDate($year, 10, 17),
            'သီတင်းကျွတ်ရုံးပိတ်ရက် ၃' => CarbonImmutable::createFromDate($year, 10, 18),
            'တန်ဆောင်မုန်းလပြည့်နေ့' => CarbonImmutable::createFromDate($year, 11, 15),
            'အမျိုးသားအောင်ပွဲနေ့' => CarbonImmutable::createFromDate($year, 11, 25),
            'ခရစ်စမတ်နေ့' => CarbonImmutable::createFromDate($year, 12, 25),
        ];
    }
}
