<?php namespace Arx\classes;

/**
 * Strings
 * PHP File - /classes/Strings.php
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Strings
 *
 * @todo
 * Configure Exception (make the custom classe first)...
 */
abstract class Strings
{

    public static function bbcode_to_html($s)
    {
        $b = array('[br]', '[h1]', '[/h1]', '[b]', '[/b]', '[strong]', '[/strong]', '[i]', '[/i]', '[em]', '[/em]', '&apos;', '&lt;', '&gt;', '&quot;');
        $h = array('<br />', '<h1>', '</h1>', '<strong>', '</strong>', '<strong>', '</strong>', '<em>', '</em>', '<em>', '</em>', '\'', '<', '>', '"');

        return str_replace($b, $h, $s);
    } // bbcode_to_html


    public static function decrypt($text, $salt)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    } // decrypt


    public static function encrypt($text, $salt)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    } // encrypt


    public static function excerpt($string, $length = 160, $trailing = '...', $strict = false)
    {
        $length -= mb_strlen($trailing);

        if ($strict) {
            $string = trim(strip_tags($string));
        }

        if (mb_strlen($string) > $length) {
            // string exceeded length, truncate and add trailing dots
            return mb_substr($string, 0, $length) . $trailing;
        } else {
            // string was already short enough, return the string
            $res = $string;
        }

        return $res;
    } // excerpt


    public static function genChar($size, $char = 'abcdefghijklmnopqrstuvxzkwyABCDEFGHIJKLMNOPQRSTUVXZKWY0123456789_')
    {
        $return = '';
        $max = strlen($char) - 1;

        for ($i = 0; $i < $size; $i++) {
            $return .= substr($char, rand(0, $max), 1);
        }

        return $return;
    } // genChar


    public static function hexToStr($hex) {
        $string = '';

        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }

        return $string;
    } // hexToStr


    public static function in_string($needle, $haystack, $sep = ',')
    {
        $array = explode($sep, $haystack);

        if (in_array($needle, $array)) {
            return true;
        }

        return false;
    } // in_string


    public static function is_json($str)
    {
       return json_decode($str) != null;
    } // is_json


    public static function json_encode_string($s)
    {
        return json_encode(array($s));
    } // json_encode_string


    /**
     * Limit text to a given number of sentences.
     *
     * @param   string
     * @param   integer
     *
     * @return  string
     */
    public static function limit_text_sentences($text, $count)
    {
        preg_match('/^([^.!?]*[\.!?]+){0,'.$count.'}/', strip_tags($text), $excerpt);

        return $excerpt[0];
    } // limit_text_sentences


    /**
     * Limit text to a given number of words.
     *
     * @param   string
     * @param   integer
     *
     * @return  string
     */
    public static function limit_text_words($text, $count)
    {
        preg_match('/^([^.!?\s]*[\.!?\s]+){0,'.$count.'}/', strip_tags($text), $excerpt);

        return $excerpt[0];
    } // limit_text_words


    public static function removeAccents($str, $charset = 'utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml|uro)\;#', '\1', $str);
        $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères

        return $str;
    } // removeAccents


    /**
     * [slug Slugify a string]
     * @param  string  $phrase
     * @param  integer $maxLength
     * @return string
     */
    public static function slug($phrase, $maxLength = 200) {
        $result = strtolower($phrase);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);

        return $result;
    } // slug


    public static function strAReplace(array $array, $str){
        return str_replace(array_keys($array), array_values($array), $str);
    }


    /**
     * Same function as strtr but add a { matches }
     *
     * @param $
     *
     * @return
     *
     * @code
     *
     * @endcode
     */
    public static function strtr($haystack, $aMatch, $aDelimiter = array("{","}")) {
        $aCleaned = array();

        foreach ($aMatch as $key => $v) {
            $aCleaned[$aDelimiter[0].$key.$aDelimiter[1]] = $v;
        }

        return strtr($haystack, $aCleaned);
    } // strtr

    public static function smrtr($haystack, $aMatch, $aDelimiter = array("{","}")) {
        return u::strtr($haystack, $aMatch, $aDelimiter);
    } // smrtr

    /**
     * Transform a strin to hexadecimal
     * @param  string $string string to convert
     * @return string hexadecimal string
     */
    public static function str_to_hex($string) {
        $hex = '';

        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }

        return $hex;
    } // str_to_hex


    /**
     * @param $haystack
     * @param array $needles
     * @param int $offset
     * @return bool|mixed
     */
    public static function strposa($haystack, $needles=array(), $offset=0) {
        $chr = array();

        foreach ($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);

            if ($res !== false) {
                $chr[$needle] = $res;
            }
        }

        if (empty($chr)) {
            return false;
        }

        return min($chr);
    } // strposa


    /**
     * Properly strip all HTML tags including script and style.
     *
     * Credit: http://core.svn.wordpress.org/trunk/wp-includes/formatting.php
     *
     * @param   string
     * @param   bool
     *
     * @return  string
     */
    public static function strip_all_tags($string, $remove_breaks = false)
    {
        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string);

        if ($remove_breaks) {
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        }

        return trim($string);
    } // strip_all_tags


    /**
     * Transform a string to particular SMS text format
     *
     * @param string $str string
     * @return string      string formatted
     */
    public static function toSMS($str) {
        $str = str_replace(array(' ', 'é', 'è', 'ó', 'à', 'â', ',', '?', "'"), array('+', '%E9', '%E8', 'o', '%E0', '%E2', '%82', '%3F', "%27"), $str);

        return $str;
    } // toSMS

} // class::Strings
