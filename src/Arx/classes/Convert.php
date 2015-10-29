<?php namespace Arx\classes;

/**
 * Convert
 *
 * Convert helpers to handle Country, fileExtType, money etc.
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.io
 */
class Convert
{
    public static $aCountries = array(
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua And Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia And Herzegowina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, The Democratic Republic Of The",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'Ivoire",
        "HR" => "Croatia (Local Name: Hrvatska)",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "TP" => "East Timor",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "FX" => "France, Metropolitan",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard And Mc Donald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran (Islamic Republic Of)",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic Of",
        "KR" => "Korea, Republic Of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau",
        "MK" => "Macedonia, Former Yugoslav Republic Of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States Of",
        "MD" => "Moldova, Republic Of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "KN" => "Saint Kitts And Nevis",
        "LC" => "Saint Lucia",
        "VC" => "Saint Vincent And The Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome And Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia (Slovak Republic)",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia, South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SH" => "St. Helena",
        "PM" => "St. Pierre And Miquelon",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard And Jan Mayen Islands",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic Of",
        "TH" => "Thailand",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad And Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks And Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Viet Nam",
        "VG" => "Virgin Islands (British)",
        "VI" => "Virgin Islands (U.S.)",
        "WF" => "Wallis And Futuna Islands",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "YU" => "Yugoslavia",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe",
    );

    /**
     * Convert a 2 digit ISO country code to a country name.
     *
     * @param string $sCode The country code (2 characters)
     *
     * @return string The country name (in english)
     */
    public static function countryName($sCode)
    {
        $sCode = strtolower($sCode);

        if(isset(self::$aCountries[$sCode])){
            return self::$aCountries[$sCode];
        }

        return false;
    } // countryName

    /**
     * Convert a 2 digit ISO country code to a country name.
     *
     * @param string $sCode The country code (2 characters)
     *
     * @return string The country name (in english)
     */
    public static function countryCode($sCountryName)
    {
        $sCountryName = strtolower($sCountryName);

        $aCountries = array_flip(self::$aCountries);

        if(isset($aCountries[$sCountryName])){
            return $aCountries[$sCountryName];
        }

        return false;
    } // countryCode


    /**
     * Convert a 2 digit ISO country code to a continent.
     *
     * @param string $sCountry The country code (2 characters)
     *
     * @return string       The continent name
     *
     */
    public static function countryToContinent($sCountry)
    {
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
    } // countryToContinent


    /**
     * Convert a file extension to a file type.
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/functions.php
     *
     * @param string $sExt The file extension
     *
     * @return string      The type
     */
    public static function fileExtType($sExt)
    {
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
    } // fileExtType

    /**
     * Return Extension to correct mimetype
     *
     * @param $ext
     * @return string
     */
    public static function extToMimeType($ext){

        if(isset(Globals::mimetypes()[$ext])){
            return Globals::mimetypes()[$ext];
        }

        return "text/html";
    }


    /**
     * Convert Http status code to description.
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/functions.php
     *
     * @param int $iCode The HTTP code
     *
     * @return string    The description
     */
    public static function httpStatusDesc($iCode)
    {
        $iCode = intval($iCode);

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
    } // httpStatusDesc


    public static function parseInt($string) {
        if ((bool) preg_match('/(\d+)/', $string, $array)) {return $array[1];
        } else {
            return false;
        }
    } // parseInt


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
     * @param int $bytes    Bytes
     * @param int $decimals Decimals
     *
     * @return  bool|string
     */
    public static function sizeFormat($bytes, $decimals = 0)
    {
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
    } // sizeFormat

} // Convert
