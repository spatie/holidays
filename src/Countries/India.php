<?php

namespace Spatie\Holidays\Countries;

use Spatie\Holidays\Exceptions\UnsupportedRegion;

class India extends Country
{

    public function countryCode(): string
    {
        return 'in';
    }

    /**
     * Reference
     * @link https://en.wikipedia.org/wiki/Public_holidays_in_India
     */
    protected function allHolidays(int $year, ?string $region = null): array
    {
        return array_merge(
            $this->fixedHolidays(),
            $this->variableHolidays($year, $region)
        );
    }

    protected function fixedHolidays(): array
    {
        # These are pretty well fixed holidays
        return [
            'Republic Day' => '01-26',
            'Labour Day' => '05-01',
            'Independence Day' => '08-15',
            'Gandhi Jayanti' => '10-02',
            'Christmas' => '12-25',
        ];
    }

    /**
     * In India there are more state specific holidays in compared to National Holidays
     * We can implement a mechanism to check the state and return the holidays accordingly
     */
    protected function variableHolidays(int $year, ?string $region = null): array
    {
        if (empty($region)) {
            return [];
        }
        return match ($region) {
            'Andhra Pradesh' => [
                'Ugadi' => '04-13',
                'Sri Rama Navami' => '04-21',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Bonalu' => '07-11',
                'Eid al-Adha' => '07-20',
                'Muharram' => '08-19',
                'Ganesh Chaturthi' => '09-10',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Kartika Purnima' => '11-19',
            ],
            'Arunachal Pradesh' => [
                'Losar' => '02-12',
                'Nyokum Yullo' => '02-26',
                'Mopin' => '04-05',
                'Tamladu' => '08-15',
                'Solung' => '09-01',
                'Dree' => '10-04',
                'Karnataka Rajyotsava' => '11-01',
                'Pangsau Pass Winter Festival' => '12-20',
            ],
            'Assam' => [
                'Magh Bihu' => '01-15',
                'Tusu Puja' => '01-15',
                'Me-Dum-Me-Phi' => '01-31',
                'Bhogali Bihu' => '01-15',
                'Sivaratri' => '03-11',
                'Dol Jatra' => '03-28',
                'Bohag Bihu' => '04-14',
                'Rongali Bihu' => '04-14',
            ],
            'Bihar' => [
                'Makar Sankranti' => '01-14',
                'Vasant Panchami' => '02-16',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
            ],
            'Chhattisgarh' => [
                'Makar Sankranti' => '01-14',
                'Vasant Panchami' => '02-16',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
                'Christmas' => '12-25',
            ],
            'Goa' => [
                'Republic Day' => '01-26',
                'Good Friday' => '04-02',
                'Gudi Padwa' => '04-13',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'May Day' => '05-01',
                'Bakri Id' => '07-21',
                'Independence Day' => '08-15',
                'Ganesh Chaturthi' => '09-10',
                'Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Diwali' => '11-04',
                'Feast of St. Francis Xavier' => '12-03',
                'Christmas' => '12-25',
            ],
            'Gujarat' => [
                'Makar Sankranti' => '01-14',
                'Vasant Panchami' => '02-16',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
                'Christmas' => '12-25',
            ],
            'Haryana' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
                'Christmas' => '12-25',
            ],
            'Himachal Pradesh' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
                'Christmas' => '12-25',
            ],
            'Jammu and Kashmir' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
                'Christmas' => '12-25',
                'Eid al-Adha' => '07-20',
                'Muharram' => '08-19',
                'Guru Nanak Gurpurab' => '11-19',
            ],
            'Jharkhand' => [
                'Makar Sankranti' => '01-14',
                'Vasant Panchami' => '02-16',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Chhath Puja' => '11-10',
                'Christmas' => '12-25',
                'Sarhul' => '04-16',
                'Karam' => '08-09',
                'Karma' => '08-09',
                'Sohrai' => '10-29',
                'Bandna' => '11-01',
                'Bhagta Parab' => '11-01',
                'Agni Utrav' => '11-01',
                'Kunda' => '11-01',
                'Sahrai' => '11-01',
                'Chhath Puja' => '11-10',
                'Kolhai' => '11-10',
                'Kolom' => '11-10',
                'Karma Puja' => '11-10',
                'Sohrai' => '11-10',
                'Bhagta Parab' => '11-10',
                'Agni Utrav' => '11-10',
                'Kunda' => '11-10',
                'Sahrai' => '11-10',
                'Karam' => '08-09',
                'Karma' => '08-09',
            ],
            'Karnataka' => [
                'Republic Day' => '01-26',
                'Makar Sankranti' => '01-14',
                'Vasant Panchami' => '02-16',
                'Maha Shivaratri' => '03-11',
                'Ugadi' => '04-13',
                'Good Friday' => '04-02',
                'Basava Jayanthi' => '04-14',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'May Day' => '05-01',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Bonalu' => '07-11',
                'Bakri Id' => '07-21',
                'Independence Day' => '08-15',
                'Muharram' => '08-19',
                'Ganesh Chaturthi' => '09-10',
                'Mahatma Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Kannada Rajyothsava' => '11-01',
                'Diwali' => '11-04',
                'Karnataka Rajyotsava' => '11-01',
                'Kanakadasa Jayanthi' => '11-01',
                'Naraka Chaturdashi' => '11-01',
                'Christmas' => '12-25',
            ],
            'Kerala' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Good Friday' => '04-02',
                'Vishu' => '04-14',
                'Easter' => '04-04',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'May Day' => '05-01',
                'Idul Fitr' => '05-14',
                'Bakri Id' => '07-21',
                'Independence Day' => '08-15',
                'Muharram' => '08-19',
                'Sree Narayana Guru Jayanti' => '08-20',
                'First Onam' => '08-21',
                'Thiruvonam' => '08-21',
                'Third Onam' => '08-23',
                'Fourth Onam' => '08-24',
                'Sree Narayana Guru Samadhi' => '09-21',
                'Mahatma Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Kerala Piravi' => '11-01',
                'Christmas' => '12-25',
            ],
            'Madhya Pradesh' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'May Day' => '05-01',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Mahatma Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Christmas' => '12-25',
            ],
            'Maharashtra' => [
                'Republic Day' => '01-26',
                'Makar Sankranti' => '01-14',
                'Vasant Panchami' => '02-16',
                'Maha Shivaratri' => '03-11',
                'Chhatrapati Shivaji Maharaj Jayanti' => '02-19',
                'Gudi Padwa' => '04-13',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Good Friday' => '04-02',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Eid al-Adha' => '07-20',
                'Bakri Id' => '07-21',
                'Independence Day' => '08-15',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Mahatma Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Guru Nanak Jayanti' => '11-19',
                'Christmas' => '12-25',
            ],
            'Manipur', 'West Bengal', 'Sikkim', 'Meghalaya', 'Mizoram', 'Nagaland', 'Punjab', 'Tripura' => [
                'Republic Day' => '01-26',
                'Guru Gobind Singh Jayanti' => '01-20',
                'Me-Dum-Me-Phi' => '01-31',
                'Lui-Ngai-Ni' => '02-15',
                'Yaosang' => '03-28',
                'Sajibu Nongma Panba' => '04-13',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Good Friday' => '04-02',
                'Khongjom Day' => '04-23',
                'Buddha Purnima' => '05-26',
                'Idul Fitr' => '05-14',
                'Kang Festival' => '07-06',
                'Patriot Day' => '08-13',
                'Independence Day' => '08-15',
                'Janmashtami' => '08-30',
                'Muharram' => '08-19',
                'Mera Chaoren Houba' => '09-17',
                'Gandhi Jayanti' => '10-02',
                'Mera Houchongba' => '10-21',
                'Diwali' => '11-04',
                'Kut' => '11-01',
                'Christmas' => '12-25',
            ],
            'Odisha' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Utkal Divas' => '04-01',
                'Good Friday' => '04-02',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Raja Sankranti' => '06-15',
                'Ratha Yatra' => '07-12',
                'Idul Fitr' => '05-14',
                'Independence Day' => '08-15',
                'Janmashtami' => '08-30',
                'Ganesh Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Kumar Purnima' => '10-20',
                'Diwali' => '11-04',
                'Christmas' => '12-25',
            ],
            'Rajasthan', 'Uttar Pradesh', 'Uttarakhand' => [
                'Republic Day' => '01-26',
                'Maha Shivaratri' => '03-11',
                'Holi' => '03-29',
                'Mahavir Jayanti' => '04-25',
                'Ram Navami' => '04-21',
                'Good Friday' => '04-02',
                'Buddha Purnima' => '05-26',
                'Idul Fitr' => '05-14',
                'Independence Day' => '08-15',
                'Raksha Bandhan' => '08-22',
                'Janmashtami' => '08-30',
                'Muharram' => '08-19',
                'Mahatma Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Diwali' => '11-04',
                'Christmas' => '12-25',
            ],
            'Tamil Nadu' => [
                'Republic Day' => '01-26',
                'Pongal' => '01-14',
                'Thiruvalluvar Day' => '01-15',
                'Uzhavar Thirunal' => '01-17',
                'Maha Shivaratri' => '03-11',
                'Telugu New Year' => '04-13',
                'Ram Navami' => '04-21',
                'Mahavir Jayanti' => '04-25',
                'Good Friday' => '04-02',
                'Easter' => '04-04',
                'Buddha Purnima' => '05-26',
                'Idul Fitr' => '05-14',
                'Bakri Id' => '07-21',
                'Independence Day' => '08-15',
                'Janmashtami' => '08-30',
                'Vinayaka Chaturthi' => '09-10',
                'Muharram' => '08-19',
                'Gandhi Jayanti' => '10-02',
                'Ayudha Puja' => '10-14',
                'Vijaya Dashami' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Deepavali' => '11-04',
                'Christmas' => '12-25',
            ],
            'Telangana' => [
                'Republic Day' => '01-26',
                'Ugadi' => '04-13',
                'Sri Rama Navami' => '04-21',
                'Buddha Purnima' => '05-26',
                'Eid al-Fitr' => '05-14',
                'Bonalu' => '07-11',
                'Eid al-Adha' => '07-20',
                'Muharram' => '08-19',
                'Ganesh Chaturthi' => '09-10',
                'Mahatma Gandhi Jayanti' => '10-02',
                'Dussehra' => '10-15',
                'Milad un-Nabi' => '10-19',
                'Diwali' => '11-04',
                'Kartika Purnima' => '11-19',
                'Christmas' => '12-25',
            ],
            default => throw UnsupportedRegion::make('India', $region)
        };


    }
}
