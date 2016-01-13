<?php namespace Arx\classes;

/**
 * Date Helpers
 *
 * @compatibilty php_>_5.3
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Date
 */
class Date
{
     /**
     * Differences in days between 2 date
     *
     * @return int
     */
    public static function daysDifference($start, $end = null, $abs = true) {
        $start = new \DateTime($start);
        
        if(!$end){
            $end = new \DateTime('today');
        } else {
            $end = new \DateTime($end);
        }
        $interval = $start->diff($end);

        return $abs ? abs($interval->format('%R%a')) : $interval->format('%R%a');
    }

    /**
     * Number of days in a month
     *
     * Takes a month/year as input and returns the number of days
     * for the given month/year. Takes leap years into consideration.
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param int $month Month
     * @param int $year  Year
     *
     * @return int
     */
    public static function daysInMonth($month = 0, $year = '')
    {
        if ($month < 1 OR $month > 12) {
            return 0;
        }

        if (!is_numeric($year) OR strlen($year) != 4) {
            $year = date('Y');
        }

        if ($month == 2) {
            if ($year % 400 == 0 OR ($year % 4 == 0 AND $year % 100 != 0)) {
                return 29;
            }
        }

        $days_in_month  = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        return $days_in_month[$month - 1];
    } // daysInMonth


    /**
     * Find last monday from a date if monday => return the monday before
     *
     * @deprecated please use lastMonday !
     */
    public static function findMonday($d = null, $format = "Y-m-d") {
        return self::lastMonday($d, $format);
    }

    /**
     * Find last monday from a date if monday => return the monday before
     * @param null $d
     * @param string $format
     * @return bool|string
     */
    public static function lastMonday($d = null, $format = "Y-m-d") {

        if(!$d){
            $d = date('Y-m-d');
        }

        return date($format, strtotime("last monday", strtotime($d)));
    }

    /**
     * Find next monday from a date if monday => return the monday before
     * @param null $d
     * @param string $format
     * @return bool|string
     */
    public static function nextMonday($d = null, $format = "Y-m-d") {

        if(!$d){
            $d = date('Y-m-d');
        }

        return date($format, strtotime("next monday", strtotime($d)));
    }

    public static function lastWeek($week = null){

        $days = array();

        $week = \Arx\classes\Date::lastMonday($week);

        for($i=0;$i<7;$i++){
            $days[] = date('Y-m-d', strtotime("+ $i day", strtotime($week)));
        }

        return $days;
    }

    public static function thisWeek($week = null){

        $days = array();

        $week = \Arx\classes\Date::thisMonday($week);

        for($i=0;$i<7;$i++){
            $days[] = date('Y-m-d', strtotime("+ $i day", strtotime($week)));
        }

        return $days;
    }

    /**
     * Get next week from a date
     *
     * @param null $week
     * @return array
     */
    public static function nextWeek($week = null){

        $days = array();

        $week = \Arx\classes\Date::nextMonday($week);

        for($i=0;$i<7;$i++){
            $days[] = date('Y-m-d', strtotime("+ $i day", strtotime($week)));
        }

        return $days;
    }

    /**
     * Return current monday if monday => return current date
     * @param null $d
     * @param string $format
     * @return bool|string
     */
    public static function thisMonday($d = null, $format = "Y-m-d") {

        # If not defined return the current monday using tomorrow trick
        if(!$d){
            $d = 'tomorrow';
        }
        // If date is defined and it's monday => return monday
        elseif(date('N', strtotime($d)) == 1){
            return date($format, strtotime($d));
        }

        // else retturn the previous monday
        return date($format, strtotime("last monday", strtotime($d)));

    }

    /**
     * Find last sunday from a date if sunday => return the sunday before
     * @param null $d
     * @param string $format
     * @return bool|string
     */
    public static function nextSunday($date = null, $format = "Y-m-d") {

        if(!$date){
            $date = date('Y-m-d');
        }

        return date($format, strtotime("next sunday", strtotime($date)));
    }

    /**
     * Return current sunday if sunday => return current date
     * @param null $d
     * @param string $format
     * @return bool|string
     */
    public static function thisSunday($d = null, $format = "Y-m-d") {

        # If not defined return the current sunday using yesterday trick
        if(!$d){
            $d = 'yesterday';
        }
        // If date is defined and it's sunday => return sunday
        elseif(date('N', strtotime($d)) == 7){
            return date($format, strtotime($d));
        }

        // else retturn the previous sunday
        return date($format, strtotime("next sunday", strtotime($d)));
    }

    /**
     * Return diff between 2 microtime
     *
     * @param $mt_old
     * @param $mt_new
     * @return float
     */
    public static function diffMicrotime($mt_old, $mt_new) {
        list($old_usec, $old_sec) = explode(' ', $mt_old);
        list($new_usec, $new_sec) = explode(' ', $mt_new);
        $old_mt = ((float) $old_usec + (float) $old_sec);
        $new_mt = ((float) $new_usec + (float) $new_sec);

        return $new_mt - $old_mt;
    } // diffMicrotime


    /**
     * Converts GMT time to a localized value
     *
     * Takes a Unix timestamp (in GMT) as input, and returns
     * at the local value based on the timezone and DST setting
     * submitted
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param int    $time     Unix timestamp
     * @param string $timezone timezone
     * @param bool   $dst      whether DST is active
     *
     * @return int
     */
    public static function gmtToLocal($time = '', $timezone = 'UTC', $dst = false)
    {
        if (empty($time)) {
            return now();
        }

        $time += timezones($timezone) * 3600;

        if ($dst) {
            $time += 3600;
        }

        return $time;
    } // gmtToLocal


    /**
     * Determines the difference between two timestamps.
     *
     * The difference is returned in a human readable format such as "1 hour",
     * "5 mins", "2 days".
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/formatting.php
     *
     * @param int $from
     * @param int $to
     *
     * @return  string
     */
    public static function humanTimeDiff($from, $to = '')
    {
        if (empty($to)) {
            $to = time();
        }

        $diff = (int) abs($to - $from);

        if ($diff <= 3600) {
            $mins = round($diff / 60);

            if ($mins <= 1) {
                $mins = 1;
            }

            if ($mins === 1) {
                $since = sprintf('%s min', $mins);
            } else {
                $since = sprintf('%s mins', $mins);
            }
        } else if (($diff <= 86400) && ($diff > 3600)) {
            $hours = round($diff / 3600);

            if ($hours <= 1) {
                $hours = 1;
            }

            if ($hours === 1) {
                $since = sprintf('%s hour', $hours);
            } else {
                $since = sprintf('%s hours', $hours);
            }
        } elseif ($diff >= 86400) {
            $days = round($diff / 86400);

            if ($days <= 1) {
                $days = 1;
            }

            if ($days === 1) {
                $since = sprintf('%s day', $days);
            } else {
                $since = sprintf('%s days', $days);
            }
        }

        return $since;
    } // humanTimeDiff


    /**
     * Convert "human" date to GMT
     *
     * Reverses the above process
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param string $datestr Format: us or euro
     *
     * @return int
     */
    public static function humanToUnix($datestr = '')
    {
        if ($datestr == '')
        {
            return FALSE;
        }

        $datestr = trim($datestr);
        $datestr = preg_replace("/\040+/", ' ', $datestr);

        if ( ! preg_match('/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}\s[0-9]{1,2}:[0-9]{1,2}(?::[0-9]{1,2})?(?:\s[AP]M)?$/i', $datestr))
        {
            return FALSE;
        }

        $split = explode(' ', $datestr);

        $ex = explode("-", $split['0']);

        $year  = (strlen($ex['0']) == 2) ? '20'.$ex['0'] : $ex['0'];
        $month = (strlen($ex['1']) == 1) ? '0'.$ex['1']  : $ex['1'];
        $day   = (strlen($ex['2']) == 1) ? '0'.$ex['2']  : $ex['2'];

        $ex = explode(":", $split['1']);

        $hour = (strlen($ex['0']) == 1) ? '0'.$ex['0'] : $ex['0'];
        $min  = (strlen($ex['1']) == 1) ? '0'.$ex['1'] : $ex['1'];

        if (isset($ex['2']) && preg_match('/[0-9]{1,2}/', $ex['2']))
        {
            $sec  = (strlen($ex['2']) == 1) ? '0'.$ex['2'] : $ex['2'];
        }
        else
        {
            // Unless specified, seconds get set to zero.
            $sec = '00';
        }

        if (isset($split['2']))
        {
            $ampm = strtolower($split['2']);

            if (substr($ampm, 0, 1) == 'p' AND $hour < 12)
                $hour = $hour + 12;

            if (substr($ampm, 0, 1) == 'a' AND $hour == 12)
                $hour =  '00';

            if (strlen($hour) == 1)
                $hour = '0'.$hour;
        }

        return mktime($hour, $min, $sec, $month, $day, $year);
    } // humanToUnix


    /**
     * Converts a local Unix timestamp to GMT
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param int $time Unix timestamp
     *
     * @return int
     */
    public static function localToGMT($time = '')
    {
        if (empty($time)) {
            $time = time();
        }

        return gmmktime(gmdate("H", $time), gmdate("i", $time), gmdate("s", $time), gmdate("m", $time), gmdate("d", $time), gmdate("Y", $time));
    } // localToGMT


    /**
     * Convert MySQL Style Datecodes
     *
     * This function is identical to PHPs date() function,
     * except that it allows date codes to be formatted using
     * the MySQL style, where each code letter is preceded
     * with a percent sign:  %Y %m %d etc...
     *
     * The benefit of doing dates this way is that you don't
     * have to worry about escaping your text letters that
     * match the date codes.
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param string $datestr
     * @param int    $time
     *
     * @return int
     */
    public static function mdate($datestr = '', $time = '')
    {
        if (empty($datestr)) {
            return '';
        }

        if (empty($time)) {
            $time = now();
        }

        $datestr = str_replace('%\\', '', preg_replace("/([a-z]+?){1}/i", "\\\\\\1", $datestr));

        return date($datestr, $time);
    } // mdate


    /**
     * Convert a month number to a month name.
     *
     * @param int $number
     *
     * @return int
     */
    public static function monthName($number)
    {
        $month_name = date("F", mktime(0, 0, 0, $number, 10));

        return $month_name;
    } // monthName


    /**
     * Converts a MySQL Timestamp to Unix
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param int $time Unix timestamp
     *
     * @return int
     */
    public static function mysqlToUnix($time = '')
    {
        // We'll remove certain characters for backward compatibility
        // since the formatting changed with MySQL 4.1
        // YYYY-MM-DD HH:MM:SS

        $time = str_replace('-', '', $time);
        $time = str_replace(':', '', $time);
        $time = str_replace(' ', '', $time);

        // YYYYMMDDHHMMSS
        return  mktime(
            substr($time, 8, 2),
            substr($time, 10, 2),
            substr($time, 12, 2),
            substr($time, 4, 2),
            substr($time, 6, 2),
            substr($time, 0, 4)
        );
    } // mysqlToUnix


    /**
     * Get "now" time and return it as time() or its GMT equivalent.
     *
     * @param bool $bGMT Set return as GMT equivalent
     *
     * @return int
     */
    public static function now($bGMT = false)
    {
        $now = time();

        if ($bGMT) {
            $now = gmmktime(gmdate("H", $now), gmdate("i", $now), gmdate("s", $now), gmdate("n", $now), gmdate("j", $now), gmdate("Y", $now));
        }

        return $now;
    } // now


    /**
     * Standard Date
     *
     * Returns a date formatted according to the submitted standard.
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param string $format
     * @param int    $time
     *
     * @return string
     */
    public static function standardDate($format = 'RFC822', $time = '')
    {
        $formats = array(
            'ATOM'      =>  '%Y-%m-%dT%H:%i:%s%Q',
            'COOKIE'    =>  '%l, %d-%M-%y %H:%i:%s UTC',
            'ISO8601'   =>  '%Y-%m-%dT%H:%i:%s%O',
            'RFC822'    =>  '%D, %d %M %y %H:%i:%s %O',
            'RFC850'    =>  '%l, %d-%M-%y %H:%m:%i UTC',
            'RFC1036'   =>  '%D, %d %M %y %H:%i:%s %O',
            'RFC1123'   =>  '%D, %d %M %Y %H:%i:%s %O',
            'RSS'       =>  '%D, %d %M %Y %H:%i:%s %O',
            'W3C'       =>  '%Y-%m-%dT%H:%i:%s%Q'
        );

        if (!isset($formats[$format])) {
            return false;
        }

        if (!$time) {
            $time = time();
        }

        return static::mdate($formats[$format], $time);
    } // standardDate


    /**
     * Timezones
     *
     * Returns an array of timezones or if a timezone is set
     * will return the number of hours offset from UTC.
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param string timezone
     *
     * @return string
     */
    public static function timezones($tz = '')
    {
        $tz = strtolower($tz);

        // Note: Don't change the order of these even though
        // some items appear to be in the wrong order
        $zones = array(
            'UM12'   => -12,
            'UM11'   => -11,
            'UM10'   => -10,
            'UM95'   => -9.5,
            'UM9'    => -9,
            'UM8'    => -8,
            'UM7'    => -7,
            'UM6'    => -6,
            'UM5'    => -5,
            'UM45'   => -4.5,
            'UM4'    => -4,
            'UM35'   => -3.5,
            'UM3'    => -3,
            'UM2'    => -2,
            'UM1'    => -1,
            'UTC'    => 0,
            'UP1'    => +1,
            'UP2'    => +2,
            'UP3'    => +3,
            'UP35'   => +3.5,
            'UP4'    => +4,
            'UP45'   => +4.5,
            'UP5'    => +5,
            'UP55'   => +5.5,
            'UP575'  => +5.75,
            'UP6'    => +6,
            'UP65'   => +6.5,
            'UP7'    => +7,
            'UP8'    => +8,
            'UP875'  => +8.75,
            'UP9'    => +9,
            'UP95'   => +9.5,
            'UP10'   => +10,
            'UP105'  => +10.5,
            'UP11'   => +11,
            'UP115'  => +11.5,
            'UP12'   => +12,
            'UP1275' => +12.75,
            'UP13'   => +13,
            'UP14'   => +14
        );

        if (empty($tz)) {
            return $zones;
        }

        if ($tz === 'gmt') {
            $tz = 'UTC';
        }

        return (!isset($zones[$tz])) ? 0 : $zones[$tz];
    } // timezones


    /**
     * Unix to "Human"
     *
     * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
     *
     * Credit: http://codeigniter.com/user_guide/helpers/date_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param int    $time    Unix timestamp
     * @param bool   $seconds whether to show seconds
     * @param string $fmt     format: us or euro
     *
     * @return string
     */
    public static function unixToHuman($time = '', $seconds = false, $fmt = 'us')
    {
        $r  = date('Y', $time).'-'.date('m', $time).'-'.date('d', $time).' ';

        if ($fmt == 'us') {
            $r .= date('h', $time).':'.date('i', $time);
        } else {
            $r .= date('H', $time).':'.date('i', $time);
        }

        if ($seconds) {
            $r .= ':'.date('s', $time);
        }

        if ($fmt == 'us') {
            $r .= ' '.date('A', $time);
        }

        return $r;
    } // unixToHuman

} // class::Date
