<?php namespace Arx\classes;

/**
 * Strings
 *
 * Very usefull string methods
 *
 * @category Utils
 * @package  Arx
 *
 */
class Str
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

    /**
     * Check that a string begin with a specified characters
     * @param $character
     * @param $string
     * @return string
     */
    public static function mustBeginWith($character = '/', $string = ''){
        if (strlen($string) > 0) {
            if (substr($string, 0, 1) != $character) {
                return $character.$string;
            } else {
                return $string;
            }
        } else {
            return $character;
        }
    }

    /**
     * Check that a string begin with a specified characters
     * @param $character
     * @param $string
     * @return string
     */
    public static function mustEndWith($character = '/', $string = ''){
        if (strlen($string) > 0) {
            if (substr($string, strlen($string) -1, 1) != $character) {
                return $string . $character;
            } else {
                return $string;
            }
        } else {
            return $character;
        }
    }

    /**
     * Remove character if begin with particular character
     *
     * @param string $character
     * @param string $string
     * @return string
     */
    public static function mustNotBeginWith($character = '/', $string = '')
    {
        if (preg_match("/" . preg_quote($character, '/') . "/i", $string)) {
            return substr($string, count($character));
        }

        return $string;
    }

    /**
     * Remove character if begin with particular character
     *
     * @param string $character
     * @param string $string
     * @return string
     */
    public static function mustNotEndWith($character = '/', $string = '')
    {
        if (preg_match('/' . preg_quote($character, '/') . '$/i', $string)) {
            return substr($string, 0, 0 - count($character));
        }

        return $string;
    }


    /**
     * Remove accents
     *
     * @param $str
     * @param string $charset
     * @return mixed|string
     */
    public static function removeAccents($str, $charset = 'utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml|uro)\;#', '\1', $str);
        $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str);
        $str = preg_replace('#\&[^;]+\;#', '', $str);

        return $str;
    } // removeAccents


    /**
     * Sanitize filename
     * @param $str
     * @return string
     */
    public static function sanitizeFilename($str)
    {
        $replace_chars = array(
            'Š'=>'S', 'š'=>'s', 'Ð'=>'Dj','Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
            'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
            'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
            'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
            'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
            'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
            'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'ƒ'=>'f'
        );
        $str = strtr($str, $replace_chars);
        $str = preg_replace(array('/[\&]/', '/[\@]/', '/[\#]/'), array('-and-', '-at-', '-number-'), $str);
        $str = preg_replace('/[^(\x20-\x7F)]*/','', $str); // removes any special chars we missed
        $str = str_replace(' ', '-', $str); // convert space to hyphen
        $str = str_replace('\'', '', $str); // removes apostrophes
        $str = preg_replace('/[^\w\-\.]+/', '', $str); // remove non-word chars (leaving hyphens and periods)
        $str = preg_replace('/[\-]+/', '-', $str); // converts groups of hyphens into one

        return strtolower($str);
    }

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
     * @param $haystack
     * @param $aMatch
     * @param array $aDelimiter
     * @deprected please use smrtr
     * @return mixed
     */
    public static function strtr($haystack, $aMatch, $aDelimiter = array("{","}")) {
        return call_user_func_array(array(self, 'smrtr'), func_get_args());
    } // strtr

    /**
     * Smrtr the smartest micro template engine
     *
     * @param $haystack
     * @param $aMatch
     * @param array $aDelimiter
     * @return string
     */
    public static function smrtr($haystack, $aMatch, $aDelimiter = array("{","}")) {
        $aCleaned = array();

        foreach ($aMatch as $key => $v) {
            if(!is_array($v) || !is_object($v)){
                $aCleaned[$aDelimiter[0].$key.$aDelimiter[1]] = $v;
            }
        }

        return strtr($haystack, $aCleaned);
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
    }

} // class::Strings
