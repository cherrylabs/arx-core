<?php namespace Arx\classes;
/**
 * Arx
 * PHP File - /classes/Convert.php
 */


abstract class Convert {

    /**
     * Convert a 2 digit ISO country code to a country name.
     *
     * @todo    - use locale !
     *
     * @param   string  $sCode      The country code (2 characters)
     * @return  string              The country name (in english)
     */
    public static function country_name($sCode) {
        $sCode = strtolower($sCode);
        $sCountry = '';

        switch ($sCode) {
            case 'af':
                $sCountry = 'Afghanistan';
                break;

            case 'ax':
                $sCountry = 'Aland Islands';
                break;

            case 'al':
                $sCountry = 'Albania';
                break;

            case 'dz':
                $sCountry = 'Algeria';
                break;

            case 'as':
                $sCountry = 'American Samoa';
                break;

            case 'ad':
                $sCountry = 'Andorra';
                break;

            case 'ao':
                $sCountry = 'Angola';
                break;

            case 'ai':
                $sCountry = 'Anguilla';
                break;

            case 'aq':
                $sCountry = 'Antarctica';
                break;

            case 'ag':
                $sCountry = 'Antigua and Barbuda';
                break;

            case 'ar':
                $sCountry = 'Argentina';
                break;

            case 'am':
                $sCountry = 'Armenia';
                break;

            case 'aw':
                $sCountry = 'Aruba';
                break;

            case 'au':
                $sCountry = 'Australia';
                break;

            case 'at':
                $sCountry = 'Austria';
                break;

            case 'az':
                $sCountry = 'Azerbaijan';
                break;

            case 'bs':
                $sCountry = 'Bahamas the';
                break;

            case 'bh':
                $sCountry = 'Bahrain';
                break;

            case 'bd':
                $sCountry = 'Bangladesh';
                break;

            case 'bb':
                $sCountry = 'Barbados';
                break;

            case 'by':
                $sCountry = 'Belarus';
                break;

            case 'be':
                $sCountry = 'Belgium';
                break;

            case 'bz':
                $sCountry = 'Belize';
                break;

            case 'bj':
                $sCountry = 'Benin';
                break;

            case 'bm':
                $sCountry = 'Bermuda';
                break;

            case 'bt':
                $sCountry = 'Bhutan';
                break;

            case 'bo':
                $sCountry = 'Bolivia';
                break;

            case 'ba':
                $sCountry = 'Bosnia and Herzegovina';
                break;

            case 'bw':
                $sCountry = 'Botswana';
                break;

            case 'bv':
                $sCountry = 'Bouvet Island (Bouvetoya)';
                break;

            case 'br':
                $sCountry = 'Brazil';
                break;

            case 'io':
                $sCountry = 'British Indian Ocean Territory (Chagos Archipelago)';
                break;

            case 'vg':
                $sCountry = 'British Virgin Islands';
                break;

            case 'bn':
                $sCountry = 'Brunei Darussalam';
                break;

            case 'bg':
                $sCountry = 'Bulgaria';
                break;

            case 'bf':
                $sCountry = 'Burkina Faso';
                break;

            case 'bi':
                $sCountry = 'Burundi';
                break;

            case 'kh':
                $sCountry = 'Cambodia';
                break;

            case 'cm':
                $sCountry = 'Cameroon';
                break;

            case 'ca':
                $sCountry = 'Canada';
                break;

            case 'cv':
                $sCountry = 'Cape Verde';
                break;

            case 'ky':
                $sCountry = 'Cayman Islands';
                break;

            case 'cf':
                $sCountry = 'Central African Republic';
                break;

            case 'td':
                $sCountry = 'Chad';
                break;

            case 'cl':
                $sCountry = 'Chile';
                break;

            case 'cn':
                $sCountry = 'China';
                break;

            case 'cx':
                $sCountry = 'Christmas Island';
                break;

            case 'cc':
                $sCountry = 'Cocos (Keeling) Islands';
                break;

            case 'co':
                $sCountry = 'Colombia';
                break;

            case 'km':
                $sCountry = 'Comoros the';
                break;

            case 'cd':
                $sCountry = 'Congo';
                break;

            case 'cg':
                $sCountry = 'Congo the';
                break;

            case 'ck':
                $sCountry = 'Cook Islands';
                break;

            case 'cr':
                $sCountry = 'Costa Rica';
                break;

            case 'ci':
                $sCountry = 'Cote d\'Ivoire';
                break;

            case 'hr':
                $sCountry = 'Croatia';
                break;

            case 'cu':
                $sCountry = 'Cuba';
                break;

            case 'cy':
                $sCountry = 'Cyprus';
                break;

            case 'cz':
                $sCountry = 'Czech Republic';
                break;

            case 'dk':
                $sCountry = 'Denmark';
                break;

            case 'dj':
                $sCountry = 'Djibouti';
                break;

            case 'dm':
                $sCountry = 'Dominica';
                break;

            case 'do':
                $sCountry = 'Dominican Republic';
                break;

            case 'ec':
                $sCountry = 'Ecuador';
                break;

            case 'eg':
                $sCountry = 'Egypt';
                break;

            case 'sv':
                $sCountry = 'El Salvador';
                break;

            case 'gq':
                $sCountry = 'Equatorial Guinea';
                break;

            case 'er':
                $sCountry = 'Eritrea';
                break;

            case 'ee':
                $sCountry = 'Estonia';
                break;

            case 'et':
                $sCountry = 'Ethiopia';
                break;

            case 'fo':
                $sCountry = 'Faroe Islands';
                break;

            case 'fk':
                $sCountry = 'Falkland Islands (Malvinas)';
                break;

            case 'fj':
                $sCountry = 'Fiji the Fiji Islands';
                break;

            case 'fi':
                $sCountry = 'Finland';
                break;

            case 'fr':
                $sCountry = 'France, French Republic';
                break;

            case 'gf':
                $sCountry = 'French Guiana';
                break;

            case 'pf':
                $sCountry = 'French Polynesia';
                break;

            case 'tf':
                $sCountry = 'French Southern Territories';
                break;

            case 'ga':
                $sCountry = 'Gabon';
                break;

            case 'gm':
                $sCountry = 'Gambia the';
                break;

            case 'ge':
                $sCountry = 'Georgia';
                break;

            case 'de':
                $sCountry = 'Germany';
                break;

            case 'gh':
                $sCountry = 'Ghana';
                break;

            case 'gi':
                $sCountry = 'Gibraltar';
                break;

            case 'gr':
                $sCountry = 'Greece';
                break;

            case 'gl':
                $sCountry = 'Greenland';
                break;

            case 'gd':
                $sCountry = 'Grenada';
                break;

            case 'gp':
                $sCountry = 'Guadeloupe';
                break;

            case 'gu':
                $sCountry = 'Guam';
                break;

            case 'gt':
                $sCountry = 'Guatemala';
                break;

            case 'gg':
                $sCountry = 'Guernsey';
                break;

            case 'gn':
                $sCountry = 'Guinea';
                break;

            case 'gw':
                $sCountry = 'Guinea-Bissau';
                break;

            case 'gy':
                $sCountry = 'Guyana';
                break;

            case 'ht':
                $sCountry = 'Haiti';
                break;

            case 'hm':
                $sCountry = 'Heard Island and McDonald Islands';
                break;

            case 'va':
                $sCountry = 'Holy See (Vatican City State)';
                break;

            case 'hn':
                $sCountry = 'Honduras';
                break;

            case 'hk':
                $sCountry = 'Hong Kong';
                break;

            case 'hu':
                $sCountry = 'Hungary';
                break;

            case 'is':
                $sCountry = 'Iceland';
                break;

            case 'in':
                $sCountry = 'India';
                break;

            case 'id':
                $sCountry = 'Indonesia';
                break;

            case 'ir':
                $sCountry = 'Iran';
                break;

            case 'iq':
                $sCountry = 'Iraq';
                break;

            case 'ie':
                $sCountry = 'Ireland';
                break;

            case 'im':
                $sCountry = 'Isle of Man';
                break;

            case 'il':
                $sCountry = 'Israel';
                break;

            case 'it':
                $sCountry = 'Italy';
                break;

            case 'jm':
                $sCountry = 'Jamaica';
                break;

            case 'jp':
                $sCountry = 'Japan';
                break;

            case 'je':
                $sCountry = 'Jersey';
                break;

            case 'jo':
                $sCountry = 'Jordan';
                break;

            case 'kz':
                $sCountry = 'Kazakhstan';
                break;

            case 'ke':
                $sCountry = 'Kenya';
                break;

            case 'ki':
                $sCountry = 'Kiribati';
                break;

            case 'kp':
                $sCountry = 'Korea';
                break;

            case 'kr':
                $sCountry = 'Korea';
                break;

            case 'kw':
                $sCountry = 'Kuwait';
                break;

            case 'kg':
                $sCountry = 'Kyrgyz Republic';
                break;

            case 'la':
                $sCountry = 'Lao';
                break;

            case 'lv':
                $sCountry = 'Latvia';
                break;

            case 'lb':
                $sCountry = 'Lebanon';
                break;

            case 'ls':
                $sCountry = 'Lesotho';
                break;

            case 'lr':
                $sCountry = 'Liberia';
                break;

            case 'ly':
                $sCountry = 'Libyan Arab Jamahiriya';
                break;

            case 'li':
                $sCountry = 'Liechtenstein';
                break;

            case 'lt':
                $sCountry = 'Lithuania';
                break;

            case 'lu':
                $sCountry = 'Luxembourg';
                break;

            case 'mo':
                $sCountry = 'Macao';
                break;

            case 'mk':
                $sCountry = 'Macedonia';
                break;

            case 'mg':
                $sCountry = 'Madagascar';
                break;

            case 'mw':
                $sCountry = 'Malawi';
                break;

            case 'my':
                $sCountry = 'Malaysia';
                break;

            case 'mv':
                $sCountry = 'Maldives';
                break;

            case 'ml':
                $sCountry = 'Mali';
                break;

            case 'mt':
                $sCountry = 'Malta';
                break;

            case 'mh':
                $sCountry = 'Marshall Islands';
                break;

            case 'mq':
                $sCountry = 'Martinique';
                break;

            case 'mr':
                $sCountry = 'Mauritania';
                break;

            case 'mu':
                $sCountry = 'Mauritius';
                break;

            case 'yt':
                $sCountry = 'Mayotte';
                break;

            case 'mx':
                $sCountry = 'Mexico';
                break;

            case 'fm':
                $sCountry = 'Micronesia';
                break;

            case 'md':
                $sCountry = 'Moldova';
                break;

            case 'mc':
                $sCountry = 'Monaco';
                break;

            case 'mn':
                $sCountry = 'Mongolia';
                break;

            case 'me':
                $sCountry = 'Montenegro';
                break;

            case 'ms':
                $sCountry = 'Montserrat';
                break;

            case 'ma':
                $sCountry = 'Morocco';
                break;

            case 'mz':
                $sCountry = 'Mozambique';
                break;

            case 'mm':
                $sCountry = 'Myanmar';
                break;

            case 'na':
                $sCountry = 'Namibia';
                break;

            case 'nr':
                $sCountry = 'Nauru';
                break;

            case 'np':
                $sCountry = 'Nepal';
                break;

            case 'an':
                $sCountry = 'Netherlands Antilles';
                break;

            case 'nl':
                $sCountry = 'Netherlands the';
                break;

            case 'nc':
                $sCountry = 'New Caledonia';
                break;

            case 'nz':
                $sCountry = 'New Zealand';
                break;

            case 'ni':
                $sCountry = 'Nicaragua';
                break;

            case 'ne':
                $sCountry = 'Niger';
                break;

            case 'ng':
                $sCountry = 'Nigeria';
                break;

            case 'nu':
                $sCountry = 'Niue';
                break;

            case 'nf':
                $sCountry = 'Norfolk Island';
                break;

            case 'mp':
                $sCountry = 'Northern Mariana Islands';
                break;

            case 'no':
                $sCountry = 'Norway';
                break;

            case 'om':
                $sCountry = 'Oman';
                break;

            case 'pk':
                $sCountry = 'Pakistan';
                break;

            case 'pw':
                $sCountry = 'Palau';
                break;

            case 'ps':
                $sCountry = 'Palestinian Territory';
                break;

            case 'pa':
                $sCountry = 'Panama';
                break;

            case 'pg':
                $sCountry = 'Papua New Guinea';
                break;

            case 'py':
                $sCountry = 'Paraguay';
                break;

            case 'pe':
                $sCountry = 'Peru';
                break;

            case 'ph':
                $sCountry = 'Philippines';
                break;

            case 'pn':
                $sCountry = 'Pitcairn Islands';
                break;

            case 'pl':
                $sCountry = 'Poland';
                break;

            case 'pt':
                $sCountry = 'Portugal, Portuguese Republic';
                break;

            case 'pr':
                $sCountry = 'Puerto Rico';
                break;

            case 'qa':
                $sCountry = 'Qatar';
                break;

            case 're':
                $sCountry = 'Reunion';
                break;

            case 'ro':
                $sCountry = 'Romania';
                break;

            case 'ru':
                $sCountry = 'Russian Federation';
                break;

            case 'rw':
                $sCountry = 'Rwanda';
                break;

            case 'bl':
                $sCountry = 'Saint Barthelemy';
                break;

            case 'sh':
                $sCountry = 'Saint Helena';
                break;

            case 'kn':
                $sCountry = 'Saint Kitts and Nevis';
                break;

            case 'lc':
                $sCountry = 'Saint Lucia';
                break;

            case 'mf':
                $sCountry = 'Saint Martin';
                break;

            case 'pm':
                $sCountry = 'Saint Pierre and Miquelon';
                break;

            case 'vc':
                $sCountry = 'Saint Vincent and the Grenadines';
                break;

            case 'ws':
                $sCountry = 'Samoa';
                break;

            case 'sm':
                $sCountry = 'San Marino';
                break;

            case 'st':
                $sCountry = 'Sao Tome and Principe';
                break;

            case 'sa':
                $sCountry = 'Saudi Arabia';
                break;

            case 'sn':
                $sCountry = 'Senegal';
                break;

            case 'rs':
                $sCountry = 'Serbia';
                break;

            case 'sc':
                $sCountry = 'Seychelles';
                break;

            case 'sl':
                $sCountry = 'Sierra Leone';
                break;

            case 'sg':
                $sCountry = 'Singapore';
                break;

            case 'sk':
                $sCountry = 'Slovakia (Slovak Republic)';
                break;

            case 'si':
                $sCountry = 'Slovenia';
                break;

            case 'sb':
                $sCountry = 'Solomon Islands';
                break;

            case 'so':
                $sCountry = 'Somalia, Somali Republic';
                break;

            case 'za':
                $sCountry = 'South Africa';
                break;

            case 'gs':
                $sCountry = 'South Georgia and the South Sandwich Islands';
                break;

            case 'es':
                $sCountry = 'Spain';
                break;

            case 'lk':
                $sCountry = 'Sri Lanka';
                break;

            case 'sd':
                $sCountry = 'Sudan';
                break;

            case 'sr':
                $sCountry = 'Suriname';
                break;

            case 'sj':
                $sCountry = 'Svalbard & Jan Mayen Islands';
                break;

            case 'sz':
                $sCountry = 'Swaziland';
                break;

            case 'se':
                $sCountry = 'Sweden';
                break;

            case 'ch':
                $sCountry = 'Switzerland, Swiss Confederation';
                break;

            case 'sy':
                $sCountry = 'Syrian Arab Republic';
                break;

            case 'tw':
                $sCountry = 'Taiwan';
                break;

            case 'tj':
                $sCountry = 'Tajikistan';
                break;

            case 'tz':
                $sCountry = 'Tanzania';
                break;

            case 'th':
                $sCountry = 'Thailand';
                break;

            case 'tl':
                $sCountry = 'Timor-Leste';
                break;

            case 'tg':
                $sCountry = 'Togo';
                break;

            case 'tk':
                $sCountry = 'Tokelau';
                break;

            case 'to':
                $sCountry = 'Tonga';
                break;

            case 'tt':
                $sCountry = 'Trinidad and Tobago';
                break;

            case 'tn':
                $sCountry = 'Tunisia';
                break;

            case 'tr':
                $sCountry = 'Turkey';
                break;

            case 'tm':
                $sCountry = 'Turkmenistan';
                break;

            case 'tc':
                $sCountry = 'Turks and Caicos Islands';
                break;

            case 'tv':
                $sCountry = 'Tuvalu';
                break;

            case 'ug':
                $sCountry = 'Uganda';
                break;

            case 'ua':
                $sCountry = 'Ukraine';
                break;

            case 'ae':
                $sCountry = 'United Arab Emirates';
                break;

            case 'gb':
                $sCountry = 'United Kingdom';
                break;

            case 'us':
                $sCountry = 'United States of America';
                break;

            case 'um':
                $sCountry = 'United States Minor Outlying Islands';
                break;

            case 'vi':
                $sCountry = 'United States Virgin Islands';
                break;

            case 'uy':
                $sCountry = 'Uruguay, Eastern Republic of';
                break;

            case 'uz':
                $sCountry = 'Uzbekistan';
                break;

            case 'vu':
                $sCountry = 'Vanuatu';
                break;

            case 've':
                $sCountry = 'Venezuela';
                break;

            case 'vn':
                $sCountry = 'Vietnam';
                break;

            case 'wf':
                $sCountry = 'Wallis and Futuna';
                break;

            case 'eh':
                $sCountry = 'Western Sahara';
                break;

            case 'ye':
                $sCountry = 'Yemen';
                break;

            case 'zm':
                $sCountry = 'Zambia';
                break;

            case 'zw':
                $sCountry = 'Zimbabwe';
                break;

            default:
                $sCountry = $sCode;
        }

        return $sCountry;
    } // country_name


    /**
     * Convert a 2 digit ISO country code to a continent.
     *
     * @todo    - use locale !
     *
     * @param   string  $sCode      The country code (2 characters)
     * @return  string              The continent name
     */
    public static function country_to_continent($sCountry){
        $sCountry = strtolower($sCountry);
        $sContinent = '';

        switch ($sCountry) {
            case 'af':
                $sContinent = 'Asia';
                break;

            case 'ax':
                $sContinent = 'Europe';
                break;

            case 'al':
                $sContinent = 'Europe';
                break;

            case 'dz':
                $sContinent = 'Africa';
                break;

            case 'as':
                $sContinent = 'Oceania';
                break;

            case 'ad':
                $sContinent = 'Europe';
                break;

            case 'ao':
                $sContinent = 'Africa';
                break;

            case 'ai':
                $sContinent = 'North America';
                break;

            case 'aq':
                $sContinent = 'Antarctica';
                break;

            case 'ag':
                $sContinent = 'North America';
                break;

            case 'ar':
                $sContinent = 'South America';
                break;

            case 'am':
                $sContinent = 'Asia';
                break;

            case 'aw':
                $sContinent = 'North America';
                break;

            case 'au':
                $sContinent = 'Oceania';
                break;

            case 'at':
                $sContinent = 'Europe';
                break;

            case 'az':
                $sContinent = 'Asia';
                break;

            case 'bs':
                $sContinent = 'North America';
                break;

            case 'bh':
                $sContinent = 'Asia';
                break;

            case 'bd':
                $sContinent = 'Asia';
                break;

            case 'bb':
                $sContinent = 'North America';
                break;

            case 'by':
                $sContinent = 'Europe';
                break;

            case 'be':
                $sContinent = 'Europe';
                break;

            case 'bz':
                $sContinent = 'North America';
                break;

            case 'bj':
                $sContinent = 'Africa';
                break;

            case 'bm':
                $sContinent = 'North America';
                break;

            case 'bt':
                $sContinent = 'Asia';
                break;

            case 'bo':
                $sContinent = 'South America';
                break;

            case 'ba':
                $sContinent = 'Europe';
                break;

            case 'bw':
                $sContinent = 'Africa';
                break;

            case 'bv':
                $sContinent = 'Antarctica';
                break;

            case 'br':
                $sContinent = 'South America';
                break;

            case 'io':
                $sContinent = 'Asia';
                break;

            case 'vg':
                $sContinent = 'North America';
                break;

            case 'bn':
                $sContinent = 'Asia';
                break;

            case 'bg':
                $sContinent = 'Europe';
                break;

            case 'bf':
                $sContinent = 'Africa';
                break;

            case 'bi':
                $sContinent = 'Africa';
                break;

            case 'kh':
                $sContinent = 'Asia';
                break;

            case 'cm':
                $sContinent = 'Africa';
                break;

            case 'ca':
                $sContinent = 'North America';
                break;

            case 'cv':
                $sContinent = 'Africa';
                break;

            case 'ky':
                $sContinent = 'North America';
                break;

            case 'cf':
                $sContinent = 'Africa';
                break;

            case 'td':
                $sContinent = 'Africa';
                break;

            case 'cl':
                $sContinent = 'South America';
                break;

            case 'cn':
                $sContinent = 'Asia';
                break;

            case 'cx':
                $sContinent = 'Asia';
                break;

            case 'cc':
                $sContinent = 'Asia';
                break;

            case 'co':
                $sContinent = 'South America';
                break;

            case 'km':
                $sContinent = 'Africa';
                break;

            case 'cd':
                $sContinent = 'Africa';
                break;

            case 'cg':
                $sContinent = 'Africa';
                break;

            case 'ck':
                $sContinent = 'Oceania';
                break;

            case 'cr':
                $sContinent = 'North America';
                break;

            case 'ci':
                $sContinent = 'Africa';
                break;

            case 'hr':
                $sContinent = 'Europe';
                break;

            case 'cu':
                $sContinent = 'North America';
                break;

            case 'cy':
                $sContinent = 'Asia';
                break;

            case 'cz':
                $sContinent = 'Europe';
                break;

            case 'dk':
                $sContinent = 'Europe';
                break;

            case 'dj':
                $sContinent = 'Africa';
                break;

            case 'dm':
                $sContinent = 'North America';
                break;

            case 'do':
                $sContinent = 'North America';
                break;

            case 'ec':
                $sContinent = 'South America';
                break;

            case 'eg':
                $sContinent = 'Africa';
                break;

            case 'sv':
                $sContinent = 'North America';
                break;

            case 'gq':
                $sContinent = 'Africa';
                break;

            case 'er':
                $sContinent = 'Africa';
                break;

            case 'ee':
                $sContinent = 'Europe';
                break;

            case 'et':
                $sContinent = 'Africa';
                break;

            case 'fo':
                $sContinent = 'Europe';
                break;

            case 'fk':
                $sContinent = 'South America';
                break;

            case 'fj':
                $sContinent = 'Oceania';
                break;

            case 'fi':
                $sContinent = 'Europe';
                break;

            case 'fr':
                $sContinent = 'Europe';
                break;

            case 'gf':
                $sContinent = 'South America';
                break;

            case 'pf':
                $sContinent = 'Oceania';
                break;

            case 'tf':
                $sContinent = 'Antarctica';
                break;

            case 'ga':
                $sContinent = 'Africa';
                break;

            case 'gm':
                $sContinent = 'Africa';
                break;

            case 'ge':
                $sContinent = 'Asia';
                break;

            case 'de':
                $sContinent = 'Europe';
                break;

            case 'gh':
                $sContinent = 'Africa';
                break;

            case 'gi':
                $sContinent = 'Europe';
                break;

            case 'gr':
                $sContinent = 'Europe';
                break;

            case 'gl':
                $sContinent = 'North America';
                break;

            case 'gd':
                $sContinent = 'North America';
                break;

            case 'gp':
                $sContinent = 'North America';
                break;

            case 'gu':
                $sContinent = 'Oceania';
                break;

            case 'gt':
                $sContinent = 'North America';
                break;

            case 'gg':
                $sContinent = 'Europe';
                break;

            case 'gn':
                $sContinent = 'Africa';
                break;

            case 'gw':
                $sContinent = 'Africa';
                break;

            case 'gy':
                $sContinent = 'South America';
                break;

            case 'ht':
                $sContinent = 'North America';
                break;

            case 'hm':
                $sContinent = 'Antarctica';
                break;

            case 'va':
                $sContinent = 'Europe';
                break;

            case 'hn':
                $sContinent = 'North America';
                break;

            case 'hk':
                $sContinent = 'Asia';
                break;

            case 'hu':
                $sContinent = 'Europe';
                break;

            case 'is':
                $sContinent = 'Europe';
                break;

            case 'in':
                $sContinent = 'Asia';
                break;

            case 'id':
                $sContinent = 'Asia';
                break;

            case 'ir':
                $sContinent = 'Asia';
                break;

            case 'iq':
                $sContinent = 'Asia';
                break;

            case 'ie':
                $sContinent = 'Europe';
                break;

            case 'im':
                $sContinent = 'Europe';
                break;

            case 'il':
                $sContinent = 'Asia';
                break;

            case 'it':
                $sContinent = 'Europe';
                break;

            case 'jm':
                $sContinent = 'North America';
                break;

            case 'jp':
                $sContinent = 'Asia';
                break;

            case 'je':
                $sContinent = 'Europe';
                break;

            case 'jo':
                $sContinent = 'Asia';
                break;

            case 'kz':
                $sContinent = 'Asia';
                break;

            case 'ke':
                $sContinent = 'Africa';
                break;

            case 'ki':
                $sContinent = 'Oceania';
                break;

            case 'kp':
                $sContinent = 'Asia';
                break;

            case 'kr':
                $sContinent = 'Asia';
                break;

            case 'kw':
                $sContinent = 'Asia';
                break;

            case 'kg':
                $sContinent = 'Asia';
                break;

            case 'la':
                $sContinent = 'Asia';
                break;

            case 'lv':
                $sContinent = 'Europe';
                break;

            case 'lb':
                $sContinent = 'Asia';
                break;

            case 'ls':
                $sContinent = 'Africa';
                break;

            case 'lr':
                $sContinent = 'Africa';
                break;

            case 'ly':
                $sContinent = 'Africa';
                break;

            case 'li':
                $sContinent = 'Europe';
                break;

            case 'lt':
                $sContinent = 'Europe';
                break;

            case 'lu':
                $sContinent = 'Europe';
                break;

            case 'mo':
                $sContinent = 'Asia';
                break;

            case 'mk':
                $sContinent = 'Europe';
                break;

            case 'mg':
                $sContinent = 'Africa';
                break;

            case 'mw':
                $sContinent = 'Africa';
                break;

            case 'my':
                $sContinent = 'Asia';
                break;

            case 'mv':
                $sContinent = 'Asia';
                break;

            case 'ml':
                $sContinent = 'Africa';
                break;

            case 'mt':
                $sContinent = 'Europe';
                break;

            case 'mh':
                $sContinent = 'Oceania';
                break;

            case 'mq':
                $sContinent = 'North America';
                break;

            case 'mr':
                $sContinent = 'Africa';
                break;

            case 'mu':
                $sContinent = 'Africa';
                break;

            case 'yt':
                $sContinent = 'Africa';
                break;

            case 'mx':
                $sContinent = 'North America';
                break;

            case 'fm':
                $sContinent = 'Oceania';
                break;

            case 'md':
                $sContinent = 'Europe';
                break;

            case 'mc':
                $sContinent = 'Europe';
                break;

            case 'mn':
                $sContinent = 'Asia';
                break;

            case 'me':
                $sContinent = 'Europe';
                break;

            case 'ms':
                $sContinent = 'North America';
                break;

            case 'ma':
                $sContinent = 'Africa';
                break;

            case 'mz':
                $sContinent = 'Africa';
                break;

            case 'mm':
                $sContinent = 'Asia';
                break;

            case 'na':
                $sContinent = 'Africa';
                break;

            case 'nr':
                $sContinent = 'Oceania';
                break;

            case 'np':
                $sContinent = 'Asia';
                break;

            case 'an':
                $sContinent = 'North America';
                break;

            case 'nl':
                $sContinent = 'Europe';
                break;

            case 'nc':
                $sContinent = 'Oceania';
                break;

            case 'nz':
                $sContinent = 'Oceania';
                break;

            case 'ni':
                $sContinent = 'North America';
                break;

            case 'ne':
                $sContinent = 'Africa';
                break;

            case 'ng':
                $sContinent = 'Africa';
                break;

            case 'nu':
                $sContinent = 'Oceania';
                break;

            case 'nf':
                $sContinent = 'Oceania';
                break;

            case 'mp':
                $sContinent = 'Oceania';
                break;

            case 'no':
                $sContinent = 'Europe';
                break;

            case 'om':
                $sContinent = 'Asia';
                break;

            case 'pk':
                $sContinent = 'Asia';
                break;

            case 'pw':
                $sContinent = 'Oceania';
                break;

            case 'ps':
                $sContinent = 'Asia';
                break;

            case 'pa':
                $sContinent = 'North America';
                break;

            case 'pg':
                $sContinent = 'Oceania';
                break;

            case 'py':
                $sContinent = 'South America';
                break;

            case 'pe':
                $sContinent = 'South America';
                break;

            case 'ph':
                $sContinent = 'Asia';
                break;

            case 'pn':
                $sContinent = 'Oceania';
                break;

            case 'pl':
                $sContinent = 'Europe';
                break;

            case 'pt':
                $sContinent = 'Europe';
                break;

            case 'pr':
                $sContinent = 'North America';
                break;

            case 'qa':
                $sContinent = 'Asia';
                break;

            case 're':
                $sContinent = 'Africa';
                break;

            case 'ro':
                $sContinent = 'Europe';
                break;

            case 'ru':
                $sContinent = 'Europe';
                break;

            case 'rw':
                $sContinent = 'Africa';
                break;

            case 'bl':
                $sContinent = 'North America';
                break;

            case 'sh':
                $sContinent = 'Africa';
                break;

            case 'kn':
                $sContinent = 'North America';
                break;

            case 'lc':
                $sContinent = 'North America';
                break;

            case 'mf':
                $sContinent = 'North America';
                break;

            case 'pm':
                $sContinent = 'North America';
                break;

            case 'vc':
                $sContinent = 'North America';
                break;

            case 'ws':
                $sContinent = 'Oceania';
                break;

            case 'sm':
                $sContinent = 'Europe';
                break;

            case 'st':
                $sContinent = 'Africa';
                break;

            case 'sa':
                $sContinent = 'Asia';
                break;

            case 'sn':
                $sContinent = 'Africa';
                break;

            case 'rs':
                $sContinent = 'Europe';
                break;

            case 'sc':
                $sContinent = 'Africa';
                break;

            case 'sl':
                $sContinent = 'Africa';
                break;

            case 'sg':
                $sContinent = 'Asia';
                break;

            case 'sk':
                $sContinent = 'Europe';
                break;

            case 'si':
                $sContinent = 'Europe';
                break;

            case 'sb':
                $sContinent = 'Oceania';
                break;

            case 'so':
                $sContinent = 'Africa';
                break;

            case 'za':
                $sContinent = 'Africa';
                break;

            case 'gs':
                $sContinent = 'Antarctica';
                break;

            case 'es':
                $sContinent = 'Europe';
                break;

            case 'lk':
                $sContinent = 'Asia';
                break;

            case 'sd':
                $sContinent = 'Africa';
                break;

            case 'sr':
                $sContinent = 'South America';
                break;

            case 'sj':
                $sContinent = 'Europe';
                break;

            case 'sz':
                $sContinent = 'Africa';
                break;

            case 'se':
                $sContinent = 'Europe';
                break;

            case 'ch':
                $sContinent = 'Europe';
                break;

            case 'sy':
                $sContinent = 'Asia';
                break;

            case 'tw':
                $sContinent = 'Asia';
                break;

            case 'tj':
                $sContinent = 'Asia';
                break;

            case 'tz':
                $sContinent = 'Africa';
                break;

            case 'th':
                $sContinent = 'Asia';
                break;

            case 'tl':
                $sContinent = 'Asia';
                break;

            case 'tg':
                $sContinent = 'Africa';
                break;

            case 'tk':
                $sContinent = 'Oceania';
                break;

            case 'to':
                $sContinent = 'Oceania';
                break;

            case 'tt':
                $sContinent = 'North America';
                break;

            case 'tn':
                $sContinent = 'Africa';
                break;

            case 'tr':
                $sContinent = 'Asia';
                break;

            case 'tm':
                $sContinent = 'Asia';
                break;

            case 'tc':
                $sContinent = 'North America';
                break;

            case 'tv':
                $sContinent = 'Oceania';
                break;

            case 'ug':
                $sContinent = 'Africa';
                break;

            case 'ua':
                $sContinent = 'Europe';
                break;

            case 'ae':
                $sContinent = 'Asia';
                break;

            case 'gb':
                $sContinent = 'Europe';
                break;

            case 'us':
                $sContinent = 'North America';
                break;

            case 'um':
                $sContinent = 'Oceania';
                break;

            case 'vi':
                $sContinent = 'North America';
                break;

            case 'uy':
                $sContinent = 'South America';
                break;

            case 'uz':
                $sContinent = 'Asia';
                break;

            case 'vu':
                $sContinent = 'Oceania';
                break;

            case 've':
                $sContinent = 'South America';
                break;

            case 'vn':
                $sContinent = 'Asia';
                break;

            case 'wf':
                $sContinent = 'Oceania';
                break;

            case 'eh':
                $sContinent = 'Africa';
                break;

            case 'ye':
                $sContinent = 'Asia';
                break;

            case 'zm':
                $sContinent = 'Africa';
                break;

            case 'zw':
                $sContinent = 'Africa';
                break;
        }

        return $sContinent;
    } // country_to_continent


    /**
     * Convert a file extension to a file type.
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/functions.php
     *
     * @param   string  $sExt       The file extension
     * @return  string              The type
     */
    public static function file_ext_type($sExt) {
        $aExt2type = array(
            'audio'       => array('aac', 'ac3', 'aif', 'aiff', 'm3a', 'm4a', 'm4b', 'mka', 'mp1', 'mp2', 'mp3', 'ogg', 'oga', 'ram', 'wav', 'wma'),
            'video'       => array('asf', 'avi', 'divx', 'dv', 'flv',  'm4v', 'mkv', 'mov', 'mp4', 'mpeg', 'mpg', 'mpv', 'ogm', 'ogv', 'qt', 'rm', 'vob', 'wmv'),
            'document'    => array('doc', 'docx', 'docm', 'dotm', 'odt', 'pages', 'pdf', 'rtf', 'wp', 'wpd'),
            'spreadsheet' => array('numbers', 'ods', 'xls', 'xlsx', 'xlsb', 'xlsm'),
            'interactive' => array('key', 'ppt', 'pptx', 'pptm', 'odp', 'swf'),
            'text'        => array('asc', 'csv', 'tsv', 'txt'),
            'archive'     => array('bz2', 'cab', 'dmg', 'gz', 'rar', 'sea', 'sit', 'sqx', 'tar', 'tgz', 'zip'),
            'code'        => array('css', 'htm', 'html', 'php', 'js'),
        );

        foreach ($aExt2type as $type => $exts) {
            if (in_array($sExt, $exts)) {
                return $type;
            }
        }

        return false;
    } // file_ext_type


    /**
     * Convert Http status code to description.
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/functions.php
     *
     * @param   int     $iCode      The HTTP code
     * @return  string              The description
     */
    public static function http_status_desc($iCode) {
        $iCode = absint($iCode);

        $aCode_to_desc = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',

            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            226 => 'IM Used',

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Reserved',
            307 => 'Temporary Redirect',

            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            510 => 'Not Extended'
        );

        if (isset($aCode_to_desc[$iCode])) {
            return $aCode_to_desc[$iCode];
        }

        return '';
    } // http_status_desc


    /**
     * Converts number of bytes to human readable number by taking the number of that unit
     * that the bytes will go into it. Supports TB value.
     *
     * Please note that integers in PHP are limited to 32 bits, unless they are on
     * 64 bit architecture, then they have 64 bit size. If you need to place the
     * larger size then what PHP integer type will hold, then use a string. It will
     * be converted to a double, which should always have 64 bit length.
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/functions.php
     *
     * @param   int
     * @param   int
     * @return  bool|string
     */
    public static function size_format($bytes, $decimals = 0) {
        $quant = array(
            // ========================= Origin ====
            'TB' => 1099511627776,  // pow( 1024, 4)
            'GB' => 1073741824,     // pow( 1024, 3)
            'MB' => 1048576,        // pow( 1024, 2)
            'kB' => 1024,           // pow( 1024, 1)
            'B ' => 1,              // pow( 1024, 0)
        );

        foreach ($quant as $unit => $mag) {
            if (doubleval($bytes) >= $mag) {
                return number_format($bytes / $mag, $decimals).' '.$unit;
            }
        }

        return false;
    } // size_format

} // Convert
