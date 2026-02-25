<?php

namespace Spatie\Holidays;

use Spatie\Holidays\Countries\Albania;
use Spatie\Holidays\Countries\Andorra;
use Spatie\Holidays\Countries\Angola;
use Spatie\Holidays\Countries\Argentine;
use Spatie\Holidays\Countries\Australia;
use Spatie\Holidays\Countries\Austria;
use Spatie\Holidays\Countries\Azerbaijan;
use Spatie\Holidays\Countries\Bahrain;
use Spatie\Holidays\Countries\Bangladesh;
use Spatie\Holidays\Countries\Belarus;
use Spatie\Holidays\Countries\Belgium;
use Spatie\Holidays\Countries\Benin;
use Spatie\Holidays\Countries\Bolivia;
use Spatie\Holidays\Countries\BosniaAndHerzegovina;
use Spatie\Holidays\Countries\Brazil;
use Spatie\Holidays\Countries\Canada;
use Spatie\Holidays\Countries\Chile;
use Spatie\Holidays\Countries\Colombia;
use Spatie\Holidays\Countries\Country;
use Spatie\Holidays\Countries\Croatia;
use Spatie\Holidays\Countries\Czechia;
use Spatie\Holidays\Countries\Denmark;
use Spatie\Holidays\Countries\DominicanRepublic;
use Spatie\Holidays\Countries\Ecuador;
use Spatie\Holidays\Countries\Egypt;
use Spatie\Holidays\Countries\ElSalvador;
use Spatie\Holidays\Countries\England;
use Spatie\Holidays\Countries\Estonia;
use Spatie\Holidays\Countries\Finland;
use Spatie\Holidays\Countries\France;
use Spatie\Holidays\Countries\Georgia;
use Spatie\Holidays\Countries\Germany;
use Spatie\Holidays\Countries\Ghana;
use Spatie\Holidays\Countries\Greece;
use Spatie\Holidays\Countries\Guatemala;
use Spatie\Holidays\Countries\Haiti;
use Spatie\Holidays\Countries\Honduras;
use Spatie\Holidays\Countries\Hungary;
use Spatie\Holidays\Countries\Iceland;
use Spatie\Holidays\Countries\India;
use Spatie\Holidays\Countries\Indonesia;
use Spatie\Holidays\Countries\Iran;
use Spatie\Holidays\Countries\Ireland;
use Spatie\Holidays\Countries\Italy;
use Spatie\Holidays\Countries\Jamaica;
use Spatie\Holidays\Countries\Japan;
use Spatie\Holidays\Countries\Kenya;
use Spatie\Holidays\Countries\Korea;
use Spatie\Holidays\Countries\Kosovo;
use Spatie\Holidays\Countries\Latvia;
use Spatie\Holidays\Countries\Liechtenstein;
use Spatie\Holidays\Countries\Lithuania;
use Spatie\Holidays\Countries\Luxembourg;
use Spatie\Holidays\Countries\Malawi;
use Spatie\Holidays\Countries\Malaysia;
use Spatie\Holidays\Countries\Maldives;
use Spatie\Holidays\Countries\Mexico;
use Spatie\Holidays\Countries\Moldova;
use Spatie\Holidays\Countries\Montenegro;
use Spatie\Holidays\Countries\Morocco;
use Spatie\Holidays\Countries\Myanmar;
use Spatie\Holidays\Countries\Nepal;
use Spatie\Holidays\Countries\Netherlands;
use Spatie\Holidays\Countries\NewZealand;
use Spatie\Holidays\Countries\Nicaragua;
use Spatie\Holidays\Countries\Nigeria;
use Spatie\Holidays\Countries\NorthernIreland;
use Spatie\Holidays\Countries\NorthMacedonia;
use Spatie\Holidays\Countries\Norway;
use Spatie\Holidays\Countries\Pakistan;
use Spatie\Holidays\Countries\Panama;
use Spatie\Holidays\Countries\Paraguay;
use Spatie\Holidays\Countries\Peru;
use Spatie\Holidays\Countries\Philippines;
use Spatie\Holidays\Countries\Poland;
use Spatie\Holidays\Countries\Portugal;
use Spatie\Holidays\Countries\Romania;
use Spatie\Holidays\Countries\Scotland;
use Spatie\Holidays\Countries\Serbia;
use Spatie\Holidays\Countries\Slovakia;
use Spatie\Holidays\Countries\Slovenia;
use Spatie\Holidays\Countries\SouthAfrica;
use Spatie\Holidays\Countries\Spain;
use Spatie\Holidays\Countries\SriLanka;
use Spatie\Holidays\Countries\Sweden;
use Spatie\Holidays\Countries\Switzerland;
use Spatie\Holidays\Countries\Syria;
use Spatie\Holidays\Countries\Taiwan;
use Spatie\Holidays\Countries\Tanzania;
use Spatie\Holidays\Countries\Tunisia;
use Spatie\Holidays\Countries\Turkey;
use Spatie\Holidays\Countries\Turkmenistan;
use Spatie\Holidays\Countries\Uganda;
use Spatie\Holidays\Countries\Ukraine;
use Spatie\Holidays\Countries\UnitedStates;
use Spatie\Holidays\Countries\Uzbekistan;
use Spatie\Holidays\Countries\Venezuela;
use Spatie\Holidays\Countries\Vietnam;
use Spatie\Holidays\Countries\Wales;
use Spatie\Holidays\Countries\Zambia;

/** @internal */
final class CountryRegistry
{
    /** @var array<string, class-string<Country>> */
    private const MAP = [
        'al' => Albania::class,
        'ad' => Andorra::class,
        'ao' => Angola::class,
        'ar' => Argentine::class,
        'au' => Australia::class,
        'at' => Austria::class,
        'az' => Azerbaijan::class,
        'bh' => Bahrain::class,
        'bd' => Bangladesh::class,
        'by' => Belarus::class,
        'be' => Belgium::class,
        'bj' => Benin::class,
        'bo' => Bolivia::class,
        'ba' => BosniaAndHerzegovina::class,
        'br' => Brazil::class,
        'ca' => Canada::class,
        'cl' => Chile::class,
        'co' => Colombia::class,
        'hr' => Croatia::class,
        'cz' => Czechia::class,
        'dk' => Denmark::class,
        'do' => DominicanRepublic::class,
        'ec' => Ecuador::class,
        'eg' => Egypt::class,
        'sv' => ElSalvador::class,
        'gb-eng' => England::class,
        'ee' => Estonia::class,
        'fi' => Finland::class,
        'fr' => France::class,
        'ge' => Georgia::class,
        'de' => Germany::class,
        'gh' => Ghana::class,
        'el' => Greece::class,
        'gt' => Guatemala::class,
        'ht' => Haiti::class,
        'hn' => Honduras::class,
        'hu' => Hungary::class,
        'is' => Iceland::class,
        'in' => India::class,
        'id' => Indonesia::class,
        'ir' => Iran::class,
        'ie' => Ireland::class,
        'it' => Italy::class,
        'jm' => Jamaica::class,
        'jp' => Japan::class,
        'ke' => Kenya::class,
        'kr' => Korea::class,
        'xk' => Kosovo::class,
        'lv' => Latvia::class,
        'li' => Liechtenstein::class,
        'lt' => Lithuania::class,
        'lu' => Luxembourg::class,
        'mw' => Malawi::class,
        'my' => Malaysia::class,
        'mv' => Maldives::class,
        'mx' => Mexico::class,
        'md' => Moldova::class,
        'me' => Montenegro::class,
        'ma' => Morocco::class,
        'mm' => Myanmar::class,
        'np' => Nepal::class,
        'nl' => Netherlands::class,
        'nz' => NewZealand::class,
        'ni' => Nicaragua::class,
        'ng' => Nigeria::class,
        'mk' => NorthMacedonia::class,
        'gb-nir' => NorthernIreland::class,
        'no' => Norway::class,
        'pk' => Pakistan::class,
        'pa' => Panama::class,
        'py' => Paraguay::class,
        'pe' => Peru::class,
        'ph' => Philippines::class,
        'pl' => Poland::class,
        'pt' => Portugal::class,
        'ro' => Romania::class,
        'gb-sct' => Scotland::class,
        'sr' => Serbia::class,
        'sk' => Slovakia::class,
        'si' => Slovenia::class,
        'za' => SouthAfrica::class,
        'es' => Spain::class,
        'lk' => SriLanka::class,
        'se' => Sweden::class,
        'ch' => Switzerland::class,
        'sy' => Syria::class,
        'tw' => Taiwan::class,
        'tz' => Tanzania::class,
        'tn' => Tunisia::class,
        'tr' => Turkey::class,
        'tm' => Turkmenistan::class,
        'ug' => Uganda::class,
        'ua' => Ukraine::class,
        'us' => UnitedStates::class,
        'uz' => Uzbekistan::class,
        've' => Venezuela::class,
        'vn' => Vietnam::class,
        'gb-cym' => Wales::class,
        'zm' => Zambia::class,
    ];

    /** @return class-string<Country>|null */
    public static function find(string $countryCode): ?string
    {
        return self::MAP[strtolower($countryCode)] ?? null;
    }

    /** @return array<string, class-string<Country>> */
    public static function all(): array
    {
        return self::MAP;
    }
}
