<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Holiday;

class Myanmar extends Country
{
    public function countryCode(): string
    {
        return 'mm';
    }

    protected function allHolidays(int $year): array
    {
        return [
            Holiday::national('လွတ်လပ်ရေးနေ့', "{$year}-01-04"),
            Holiday::national('ကရင်နှစ်သစ်ကူးနေ့', "{$year}-01-11"),
            Holiday::national('ပြည်ထောင်စုနေ့', "{$year}-02-12"),
            Holiday::national('တောင်သူလယ်သမားနေ့', "{$year}-03-02"),
            Holiday::national('တပေါင်းလပြည့်နေ့', "{$year}-03-24"),
            Holiday::national('တပ်မတော်နေ့', "{$year}-03-27"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၁', "{$year}-04-13"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၂', "{$year}-04-14"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၃', "{$year}-04-15"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၄', "{$year}-04-16"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၅', "{$year}-04-17"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၆', "{$year}-04-18"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၇', "{$year}-04-19"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၈', "{$year}-04-20"),
            Holiday::national('မြန်မာနှစ်သစ်ကူးရုံးပိတ်ရက် ၉', "{$year}-04-21"),
            Holiday::national('အလုပ်သမားနေ့', "{$year}-05-01"),
            Holiday::national('ကဆုန်လပြည့်နေ့', "{$year}-05-22"),
            Holiday::national('အာဇာနည်နေ့', "{$year}-07-19"),
            Holiday::national('ဝါဆိုလပြည့်နေ့', "{$year}-07-20"),
            Holiday::national('သီတင်းကျွတ်ရုံးပိတ်ရက် ၁', "{$year}-10-16"),
            Holiday::national('သီတင်းကျွတ်ရုံးပိတ်ရက် ၂', "{$year}-10-17"),
            Holiday::national('သီတင်းကျွတ်ရုံးပိတ်ရက် ၃', "{$year}-10-18"),
            Holiday::national('တန်ဆောင်မုန်းလပြည့်နေ့', "{$year}-11-15"),
            Holiday::national('အမျိုးသားအောင်ပွဲနေ့', "{$year}-11-25"),
            Holiday::national('ခရစ်စမတ်နေ့', "{$year}-12-25"),
        ];
    }
}
