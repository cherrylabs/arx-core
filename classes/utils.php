<?php
/**
 * Class arx utils
 */

if(!defined('ARX_STARTTIME')){ define('ARX_STARTTIME', microtime(true)); }

abstract class u
{

    public function __call($name, $arguments)
    {
        switch (true) {
            case is_file(DIR_CLASSES . 'utils' . DS . $name . EXT_PHP):

                require_once(DIR_CLASSES . 'utils' . DS . $name . EXT_PHP);

                try {
                    return call_user_func_array($name, $arg);
                } catch (Exception $e) {

                }

                break;

        }
    }

#A :

    public static function alias($aliasName, $callback)
    {
        $err = false;
        if (function_exists($aliasName)) {
            $err = 'This function already' . $aliasName . ' exist';
        }
        if (!is_callable($callback, false, $realfunc)) {
            $err = 'This function is not callable';
        }
        if (false !== $err) {
            $trace = debug_backtrace();
            trigger_error(
                sprintf(
                    '%s(): %s in %s on line %d',
                    $trace[0]['function'],
                    $err,
                    $trace[0]['file'],
                    $trace[0]['line']
                ),
                E_USER_WARNING
            );

            return false;
        }
        $bodyFunc = 'function ' . $aliasName . '() {
            $args = func_get_args();

            return call_user_func_array("' . $realfunc . '", $args);
        }';
        eval($bodyFunc);

        return true;
    }

    /**
     * Array_assign_key assign the key
     * example array_assign_keys(array(0 => array("name" => B), 1 => array("name" => "A")), "name")
     * will return array("A" => array("name" => B, "__key" => "1"), "B" => array("name" => B, "__key" => "0"))
     * @param $array, $key
     *
     * @return
     *
     * @code
     *
     * @endcode
     */
    public static function array_assign_subkey($arr, $context = array(), &$conflict = array())
    {
        $aNew = array();

        //default option
        $c = array(
            "old_key" => "_key"
        );

        if (is_string($context)) {
            $c['key'] = $context;
        } elseif (is_array($context)) {
            $c = array_merge($c, $context);
        }

        foreach ($arr as $key=>$v) {
            if (is_object($v)) {

            } elseif (is_array($v)) {
                if (isset($v[$c['key']])) {
                    if(!isset($c['delete_old_key']))    $v[$c['old_key']] = $key;

                    $aNew[$v[$c['key']]] = $v;
                }
            }
        }

        return $aNew;
    }

    public static function array_filter_keys($a, $c = null)
    {

        if (isset($c['with'])) {
            $data = array();
            foreach
            ($a as $key=>$v) {
                if (strpos($key, $c['with'])) {
                    $data[$key] = $v;
                }
            }

            return $data;
        } else

            return array_filter($a);

    }

    public static function array_filter_values($array, $c = null)
    {
        if (isset($c['with'])) {
            $data = array();
            foreach
            ($a as $key=>$v) {
                if (strpos($v, $c['with'])) {
                    $data[$key] = $v;
                }
            }

            return $data;
        } else

            return array_filter($a);
    }

    /**
     * return the next element of a specific key
     *
     * @param $
     *
     * @return
     *
     * @code
     *
     * @endcode
     */
    public static function array_next_element($arr, $nested_key, $iteration = 1)
    {
        foreach ($arr as $key=>$v) {
            current($arr);
            if ($key == $nested_key) {
                for($i =0; $i < $iteration; $i++)
                    $return = next($arr);

                if (!empty($return)) {
                    return $return;
                } else {
                    return false;
                }
            }

            next($arr);
        }

        return false;

    }

    public static function array_prev_element($arr, $nested_key, $iteration = 1)
    {
        foreach ($arr as $key=>$v) {
            if ($key == $nested_key) {
                for($i =0; $i < $iteration; $i++)
                    $return = prev($arr);

                if (!empty($return)) {
                    return $return;
                } else {
                    return false;
                }

            }

            next($arr);

        }

    }

    public static function array_to_CSV($data)
    {
        $outstream = fopen("php://temp", 'r+');
        fputcsv($outstream, $data, ',', '"');
        rewind($outstream);
        $csv = fgets($outstream);
        fclose($outstream);

        return $csv;
    }
    public static function arrayToCsv($data)
    {
        return self::array_to_CSV($data);
    }

    public static function arrayToObject($d)
    {
        if(is_array($d)) return (object) array_map(array('u', 'arrayToObject'), $d);
        else return $d;
    }

#B :
    public static function bbcode_to_html($s)
    {
        $b = array('[br]', '[h1]', '[/h1]', '[b]', '[/b]', '[strong]', '[/strong]', '[i]', '[/i]', '[em]', '[/em]', '&apos;', '&lt;', '&gt;', '&quot;');
        $h = array('<br />', '<h1>', '</h1>', '<strong>', '</strong>', '<strong>', '</strong>', '<em>', '</em>', '<em>', '</em>', '\'', '<', '>', '"');

        return str_replace($b, $h, $s);
    }

    public static function benchIt()
    {
        if(function_exists('xdebug_time_index'))    return xdebug_time_index();
        else    return microtime();
    }

    public static function build_query_get($aAdd = null, $aRemove = null)
    {
        $aGet = $_GET;

        foreach ($aAdd as $key => $value) {
            $aGet[$key] = $value;
        }

        foreach ($aRemove as $key) {
            unset($aGet[$key]);
        }

        //predie($aGet);
        return http_build_query($aGet);
    }

#C :

    public static function check_email($mail)
    {
        if(strlen($mail) > 80) return false;

        return (bool) preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|("[^"]+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\d\-]+\.)+[a-zA-Z]{2,}))$/', $mail);
    }

    public static function checkSession()
    {
        if(!isset($_SESSION)) session_start();
    }

    public static function check_session()
    {
        return self::checkSession();
    }

    public static function cleanParam($array, $mysql = false)
    {
        if (isset($array) && is_array($array)) {
            if ($mysql === true) {
                foreach ($array as $key => $val) {
                    $array[$key] = mysql_real_escape_string($val);
                }
            } else {
                foreach ($array as $key => $val) {
                    $array[$key] = u::cleanVar($val);
                }
            }

            return $array;
        }

        return false;
    } // cleanParam

    public static function cleanVar($var, $charset = 'UTF-8')
    {
        return htmlentities($var, ENT_QUOTES, $charset);
    } // cleanVar

    public static function curl_get($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);

        return $return;
    }

#D :
    public static function diffMicrotime($mt_old, $mt_new)
    {
        list($old_usec, $old_sec) = explode(' ', $mt_old);
        list($new_usec, $new_sec) = explode(' ', $mt_new);
        $old_mt = ((float) $old_usec + (float) $old_sec);
        $new_mt = ((float) $new_usec + (float) $new_sec);

        return $new_mt - $old_mt;
    }

#E :

    public static function ecom($c='', $type = 'html')
    {
        echo '<!-- '.$c.' -->';
    }

    public static function encrypt($text)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SALT, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    public static function decrypt($text)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SALT, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    public static function epre($v)
    {
        return '<pre style="background: #fff;border: 1px solid grey;clear: both;color: black;display: block;margin: 5px;padding: 5px;position: relative;width: 50%;z-index: 9999;">'.print_r($v, true).'</pre>';
    }

#F :

#G :

    public static function genChar($size, $char = 'abcdefghijklmnopqrstuvxzkwyABCDEFGHIJKLMNOPQRSTUVXZKWY0123456789_')
    {
        $return = '';
        $max = strlen($char) - 1;

        for
        ($i = 0; $i < $size; $i++) $return .= substr($char, rand(0, $max), 1);

        return $return;
    }

    public static function getGets()
    {
        if (!empty($_GET)) {
            $a = array_keys($_GET);

            return strip_tags($a[0]);
        }

        return false;
    }

    public static function getHeight($image)
    {
        $sizes = getimagesize($image);
        $height = $sizes[1];

        return $height;
    }

    public static function getWidth($image)
    {
        $sizes = getimagesize($image);
        $width = $sizes[0];

        return $width;
    }

    public static function get_json($file, $as_array = false)
    {
        if(!empty($file)) {
            return json_decode(@file_get_contents(u::getURL($file)), $as_array);
        }

        return false;
    }

    public static function get_contents($file)
    {
        return @file_get_contents(u::getURL($file));
    }

    public static function getIp()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function getURLFile($file)
    {
        return str_replace(DIR_ROOT, URL_ROOT, $file);
    }

    public static function getURLPath($file = null)
    {
        if (is_file($file)) {
            return str_replace(DIR_ROOT, URL_ROOT, dirname($file));
        } elseif(is_dir($file))

            return str_replace(DIR_ROOT, URL_ROOT, $file);

        return $_SERVER['HTTP_HOST'].str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    }

    /**
     * Try to get the http url
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public static function getURL($file = null)
    {

        if(!preg_match('/http/i', $file))
        {
            if (is_file($file)) {
                return str_replace(array(DIR_ROOT, DS), array(URL_ROOT, "/"), $file);
            } elseif(is_dir($file))
            {
                return str_replace(array(DIR_ROOT, DS), array(URL_ROOT, "/"), $file);
            }


            return str_replace(DS, "/", $_SERVER['HTTP_HOST'].str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
        }

        return $file;
    }

    public static function getVideoEmbed($url, $width = 560, $height = 315)
    {
        switch(true)
        {
            case preg_match('/youtu/i', $url):
                $url_string = parse_url($url, PHP_URL_QUERY);
                parse_str($url_string, $args);
                $id = isset($args['v']) ? $args['v'] : false;
                
                if(!empty($id))
                    return '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
                else
                    return false;
            break;
            
            case preg_match('/vimeo/', $url):
                sscanf(parse_url($url, PHP_URL_PATH), '/%d', $id);
                if(!empty($id))
                    return '<iframe src="http://player.vimeo.com/video/'.$id.'?portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                else
                    return false;
            break;
        }
    
    }

    public static function getBrowserLanguage()
    {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

#H :
    public static function hexToStr($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }

        return $string;
    }

    public static function header($type)
    {
        include_once(dirname(__FILE__).DS.'utils'.DS.'header.php');

        header($aHeader[$type]);
    }

#I :

    //Check if the $needle is in the string haystack separated by a defined separator
    public static function in_string($needle, $haystack, $sep = ',')
    {
        $array = explode($sep, $haystack);

        if (in_array($needle, $array)) {
            return true;
        }

        return false;
    }

    public static function is_json($str)
    {
       return json_decode($str) != null;
    }

    public static function is_md5($str)
    {
       return (bool) preg_match('/^[0-9a-f]{32}$/i', $str);
    }

    public static function is_sha1($str)
    {
       return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
    }

    public static function is_sha256($str)
    {
       return (bool) preg_match('/^[0-9a-f]{64}$/i', $str);
    }

    public static function is_multi_array($arr)
    {
        if (count($myarray) == count($myarray, COUNT_RECURSIVE)) {
          return false;
        } else {
          return true;
        }
    }

#J :
    public static function json_encode_string($s)
    {
        $a = json_encode(array($s));

        return $a;
    }

    public static function json_die($array)
    {
        header("content-type: application/json");
        die(json_encode($array, true));
    }

#K :

    public static function k($string = '')
    {

        $aErrors = debug_backtrace();

        foreach ($aErrors as $key => $error) {
            if ($error['function'] == 'k' && !empty($error['line']) && !empty($error['file'])) {
                $line = $error['line'];
                $file = $error['file'];
            }
        }

        $start = ARX_STARTTIME;

        $time = microtime(true);
        $total_time = ($time - $start);

        trigger_error("K called @ $file line $line loaded in ".$total_time. " seconds");
        
        exit;
    }

#L :

    /**
     * Lazy parser
     *
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @description :
     * @comments :
     */

    public static function lazy_encode()
    {
        $arg = func_get_args();

        $a = explode('|', $arg[0]);

        foreach
        ($a as $r) {

        }

        return $string;

    }

    public static function lazy_decode()
    {
        $arg = func_get_args();

        $default = array('&', '|', '{', '(', '<', ',');

        $a4 = explode('&', $arg[0]);

        foreach
        ($a4 as $r) {
            $a3 = explode('=', $arg[0]);
            $array[$a3[0]] = explode(',', $a3[1]);
        }

        return $array;
    }

#M :

    public static function multiexplode($l = array(), $s = '')
    {
        $tr[0] = explode($l[0], $s);
        $msg = array();
        #TO DO : a more recursive function_exists
        foreach
        ($tr[0] as $key=>$t) {
            $r = explode($l[1], $t);
            $rKey = trim($r[0]);
            $msg[$rKey] = $r[1];
        }

        return $msg;
    }

#N :

#O :

    public static function objectToArray($d)
    {
        // Gets the properties of the given object with get_object_vars function
        if(is_object($d)) $d = get_object_vars($d);

        // Return array converted to object (recursive call)
        if(is_array($d)) return array_map(array('u', 'objectToArray'), $d);
        // Return array
        else return $d;
    } // objectToArray

#P :

    public static function parseInt($string)
    {
        if((bool) preg_match('/(\d+)/', $string, $array)) return $array[1];
        else  return false;
    }

    /**
    * Parses a user agent string into its important parts
    * 
    * @author Jesse G. Donat <donatj@gmail.com>
    * @link https://github.com/donatj/PhpUserAgent
    * @link http://donatstudios.com/PHP-Parser-HTTP_USER_AGENT
    * @param string $u_agent
    * @return array an array with browser, version and platform keys
    */
    public static function parseUserAgent($u_agent = null) { 
        if (is_null($u_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
            $u_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $data = array(
            'platform' => null,
            'browser'  => null,
            'version'  => null,
        );
        
        if (!$u_agent) {
            return $data;
        }
        
        if (preg_match('/\((.*?)\)/im', $u_agent, $regs)) {

            preg_match_all('/(?P<platform>Android|CrOS|iPhone|iPad|Linux|Macintosh|Windows(\ Phone\ OS)?|Silk|linux-gnu|BlackBerry|Nintendo\ (WiiU?|3DS)|Xbox)
                (?:\ [^;]*)?
                (?:;|$)/imx', $regs[1], $result, PREG_PATTERN_ORDER);

            $priority = array('Android', 'Xbox');
            $result['platform'] = array_unique($result['platform']);

            if (count($result['platform']) > 1) {
                if ($keys = array_intersect($priority, $result['platform'])) {
                    $data['platform'] = reset($keys);
                } else {
                    $data['platform'] = $result['platform'][0];
                }
            } elseif (isset($result['platform'][0])) {
                $data['platform'] = $result['platform'][0];
            }
        }

        if ($data['platform'] == 'linux-gnu') {
            $data['platform'] = 'Linux';
        }
        
        if ($data['platform'] == 'CrOS') {
            $data['platform'] = 'Chrome OS';
        }

        preg_match_all('%(?P<browser>Camino|Kindle(\ Fire\ Build)?|Firefox|Safari|MSIE|AppleWebKit|Chrome|IEMobile|Opera|Silk|Lynx|Version|Wget|curl|NintendoBrowser|PLAYSTATION\ \d+)
                (?:;?)
                (?:(?:[/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%x', 
        $u_agent, $result, PREG_PATTERN_ORDER);

        $key = 0;

        $data['browser'] = $result['browser'][0];
        $data['version'] = $result['version'][0];

        if (($key = array_search( 'Kindle Fire Build', $result['browser'] )) !== false || ($key = array_search( 'Silk', $result['browser'] )) !== false) {
            $data['browser']  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
            $data['platform'] = 'Kindle Fire';

            if (!($data['version'] = $result['version'][$key]) || !is_numeric($data['version'][0])) {
                $data['version'] = $result['version'][array_search( 'Version', $result['browser'] )];
            }
        } elseif (($key = array_search( 'NintendoBrowser', $result['browser'] )) !== false || $data['platform'] == 'Nintendo 3DS') {
            $data['browser']  = 'NintendoBrowser';
            $data['version']  = $result['version'][$key];
        } elseif (($key = array_search( 'Kindle', $result['browser'] )) !== false) {
            $data['browser']  = $result['browser'][$key];
            $data['platform'] = 'Kindle';
            $data['version']  = $result['version'][$key];
        } elseif ($result['browser'][0] == 'AppleWebKit') {
            if (( $data['platform'] == 'Android' && !($key = 0) ) || $key = array_search( 'Chrome', $result['browser'] )) {
                $data['browser'] = 'Chrome';

                if (($vkey = array_search( 'Version', $result['browser'] )) !== false) {
                    $key = $vkey;
                }
            } elseif ($data['platform'] == 'BlackBerry') {
                $data['browser'] = 'BlackBerry Browser';

                if (($vkey = array_search( 'Version', $result['browser'] )) !== false) {
                    $key = $vkey;
                }
            } elseif ($key = array_search( 'Safari', $result['browser'] )) {
                $data['browser'] = 'Safari';

                if (($vkey = array_search( 'Version', $result['browser'] )) !== false) {
                    $key = $vkey;
                }
            }
            
            $data['version'] = $result['version'][$key];
        } elseif ( ($key = array_search( 'Opera', $result['browser'] )) !== false) {
            $data['browser'] = $result['browser'][$key];
            $data['version'] = $result['version'][$key];

            if (($key = array_search( 'Version', $result['browser'] )) !== false) {
                $data['version'] = $result['version'][$key];
            }
        } elseif ($result['browser'][0] == 'MSIE') {
            if ($key = array_search( 'IEMobile', $result['browser'] )) {
                $data['browser'] = 'IEMobile';
            } else {
                $data['browser'] = 'MSIE';
                $key = 0;
            }

            $data['version'] = $result['version'][$key];
        } elseif ($key = array_search( 'PLAYSTATION 3', $result['browser'] ) !== false) {
            $data['platform'] = 'PLAYSTATION 3';
            $data['browser']  = 'NetFront';
        }

        return $data;
    }

    public static function pre()
    {
        $aArgs = func_get_args();

        foreach ($aArgs as $key => $value) {

            echo self::epre($value);
        }
    }

    public static function predie($v)
    {
        $aArgs = func_get_args();

        foreach ($aArgs as $key => $value) {

            echo self::epre($value);
        }
        
        $aErrors = debug_backtrace();

        foreach ($aErrors as $key => $error) {
            if ($error['function'] == 'predie' && !empty($error['line']) && !empty($error['file'])) {
                $line = $error['line'];
                $file = $error['file'];
            }
        }

        $start = ARX_STARTTIME;

        $time = microtime(true);
        $total_time = ($time - $start);

        die("Predie called @ $file line $line loaded in ".$total_time. " seconds");
    }

    /**
     * put_json
     *
     * @param $
     *
     * @return
     *
     * @code
     *
     * @endcode
     */
    public static function put_json($dest, $value, $type = false)
    {
        return @file_put_contents($dest, json_encode($value));
    }

#Q :

#R :

    public static function randGen($numb = 10, $c = '')
    {

        if(!is_array($c)) $c = json_decode($c, true);

        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        if($c['with'] == 'specialchars')
            $chaine .= "éâ'`,!('&#$*^";
        if(!empty($c['add']))
            $chaine .= $c['add'];
        if(!empty($c['only']))
            $chaine = $c['only'];

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'];
    }

    public static function randString($numb = 10, $c = '')
    {

        if(!is_array($c)) $c = json_decode($c, true);

        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        if($c['with'] == 'specialchars')
            $chaine .= "éâ'`,!('&#$*^";
        if(!empty($c['add']))
            $chaine .= $c['add'];
        if(!empty($c['only']))
            $chaine = $c['only'];

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'];
    }

    public static function randNum($numb = 10, $c = '')
    {

        if(!is_array($c)) $c = json_decode($c, true);

        $chaine = '0123456789';

        if($c['with'] == 'specialchars')
            $chaine .= "éâ'`,!('&#$*^";
        if(!empty($c['add']))
            $chaine .= $c['add'];
        if(!empty($c['only']))
            $chaine = $c['only'];

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'];
    }

    public static function randEmail($numb = 10, $c = '')
    {

        if(!is_array($c)) $c = json_decode($c, true);

        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

        if($c['with'] == 'specialchars')
            $chaine .= "éâ'`,!('&#$*^";
        if(!empty($c['add']))
            $chaine .= $c['add'];
        if(!empty($c['only']))
            $chaine = $c['only'];

        if(!empty($c['domain']))
            $domain = $c['domain'];
        else
            $domain = substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).'.com';

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'].'@'.$domain;
    }

    public static function randArray($a, $c = '')
    {

        if(!is_array($c)) $c = json_decode($c, true);

        if (!empty($c['num'])) {
            for
            ($i = 1; $i <= $c['num']; $i++) {
                $r .= $c['prepend'].$a[array_rand($input, 1)].$c['append'];
            }

            return $r;
        } else {
            return $a[array_rand($a, 1)];
        }
    }

    public static function removeSVN( $dir )
    {
        $out = array();

        $out[] = "Searching: $dir\n\t";

        $flag = false; // haven't found .svn directory
        $svn = $dir . '.svn';

        if ( is_dir( $svn ) ) {
            if( !chmod( $svn, 0777 ) )
                $out[] = "File permissions could not be changed (this may or may not be a problem--check the statement below).\n\t"; // if the permissions were already 777, this is not a problem

            self::removeTree( $svn ); // remove the .svn directory with a helper function

            if( is_dir( $svn ) ) // deleting failed
                $out[] = "Failed to delete $svn due to file permissions.";
            else
                $out[] = "Successfully deleted $svn from the file system.";

            $flag = true; // found directory
        }

        if( !$flag ) // no .svn directory
            $out[] = 'No .svn directory found.';
        $out[] = "\n\n";

        $handle = opendir( $dir );
        while ( false !== ( $file = readdir( $handle ) ) ) {
            if( $file == '.' || $file == '..' ) // don't get lost by recursively going through the current or top directory
                continue;

            if( is_dir( $dir . $file ) )
                self::removeSVN( $dir . $file . '/' ); // apply the SVN removal for sub directories
        }

        return $out;
    }

    public static function removeTree( $dir )
    {
        $files = glob( $dir . '*', GLOB_MARK ); // find all files in the directory

        foreach ($files as $file) {
            if( substr( $file, -1 ) == '/' )
                self::removeTree( $file ); // recursively apply this to sub directories
            else
                unlink( $file );
        }

        if ( is_dir( $dir ) )
            rmdir( $dir ); // remove the directory itself (rmdir only removes a directory once it is empty)
    }

    public static function removeAccents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#\&([A-za-z])(?:acute|cedil|circ|grave|ring|tilde|uml|uro)\;#', '\1', $str);
        $str = preg_replace('#\&([A-za-z]{2})(?:lig)\;#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#\&[^;]+\;#', '', $str); // supprime les autres caractères

        return $str;
    }

    public static function resizeImage($image, $width, $height, $scale)
    {
        $newImageWidth = ceil($width*$scale);
        $newImageHeight = ceil($height*$scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        switch
        ($ext) {
        case ($ext == 'jpg' || $ext == 'jpeg'):
            $source = imagecreatefromjpeg($image);
            break;
        case 'gif':
            $source = imagecreatefromgif($image);
            break;
        case 'png':
            $source = imagecreatefrompng($image);
            break;
        }
        //  $source = imagecreatefromjpeg($image) || imagecreatefromgif($image) || imagecreatefrompng($image);
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $width, $height);
        imagejpeg($newImage, $image, 90);
        chmod($image, 0777);

        return $image;
    }

    public static function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
    {
        $newImageWidth = ceil($width*$scale);
        $newImageHeight = ceil($height*$scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $source = imagecreatefromjpeg($image);
        imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
        imagejpeg($newImage, $thumb_image_name, 90);
        chmod($thumb_image_name, 0777);

        return $thumb_image_name;
    }

#S :

    /**
     * SendEmail
     * @param $recipient
     * @return
     * @todo make more customisable !
     */
    public static function sendMail($recipient, $subject = null, $html, $c = null)
    {
        $c = u::toArray($c);
        $headers = 'From: '.stripslashes($c['exp_nom']).' <'.$c['exp_mail'].'>' . "\r\n";
        $headers .= 'MIME-version: 1.0'."\n";
        $headers .= 'Content-type: text/html; charset=UTF-8'."\n";
        $headers .= 'Reply-To: '.$c['exp_mail']. "\r\n";
        $success = mail($recipient, '=?UTF-8?B?'.base64_encode($subject).'?=', stripslashes($html), $headers);

        return $success;
    }

    /**
     * [slug Slugify a string]
     * @param  string  $phrase
     * @param  integer $maxLength
     * @return string
     */
    public static function slug($phrase, $maxLength = 200)
    {
        $result = strtolower($phrase);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);

        return $result;
    } // slug

    /**
     * strpos with array needle
     *
     * @author Dave
     * @version 0.1
     * @package
     * @description :
     * @comments : http://www.php.net/manual/en/function.strpos.php#107351
     */

    public static function strposa($haystack, $needles=array(), $offset=0)
    {
        $chr = array();
        foreach
        ($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;

        return min($chr);
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
    public static function strtr($haystack, $aMatch, $aDelimiter = array("{","}"))
    {
        $aCleaned = array();
        foreach ($aMatch as $key => $v) {
            $aCleaned[$aDelimiter[0].$key.$aDelimiter[1]] = $v;
        }

        return strtr($haystack, $aCleaned);
    }

    /**
     * Transform a strin to hexadecimal
     * @param  string $string string to convert
     * @return string hexadecimal string
     */
    public static function str_to_hex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }

        return $hex;
    }

    /**
     * Suckplode : add a value to a string seperated by a separator
     * @param  string $value
     * @param  string $string to add
     * @param  string $sep    $separator
     * @param  bool   $unique define if the value should be unique
     * @return string
     */
    public static function suckplode($value, $string, $sep = ',', $unique = true)
    {

        $array = explode($sep, $string);

        if ($unique == true && in_array($value, $array)) {
            return $string;
        }

        array_push($array, $value);

        return implode($sep, array_filter($array));
    }

#T :

    /**
     * Transform a string to array using json, or lazy encode
     * @param mix $s mix string
     * @param array $c options
     * @return array    array
     */
    public static function toArray($s, $c = null)
    {

        $array = array();

        if (is_string($s)) {
            switch (true) {
                case(strpos($s, '{')):
                    $_type = 'json';
                    $array = json_decode($s, true);
                    break;
                case(preg_match('/,/i', $s) && !preg_match('/=/i', $s)):
                    $_type = 'explode';
                    $array = explode(',', $s);
                    break;
                case(preg_match('/,/i', $s)):
                    $_type = 'lazy';
                    $array = self::lazy_decode($s);
                    predie($array);
                    break;
            }

        } elseif (is_object($s)) {
            return self::objectToArray($s);
        } else {
            $array = $s;
        }

        if ($c == 'DEBUG') {
            predie($s);
        }

        switch (true) {
            case ($c == 'DEBUG'):
            case ($c == 'debug'):
                predie(
                    array($s, $array, $_type)
                );
                break;
        }

        return $array;

    }

    /**
     * Transform a string to particular SMS text format
     * 
     * @param string $str string
     * @return string      string formatted
     */
    public static function toSMS($str)
    {
        $str = str_replace(array(' ', 'é', 'è', 'ó', 'à', 'â', ',', '?', "'"), array('+', '%E9', '%E8', 'o', '%E0', '%E2', '%82', '%3F', "%27"), $str);

        return $str;
    }

#U :

#V :

#W :

#X :

#Y :

#Z :

}

/*----- Alias functions (shortcut) -----*/

/**
 * [pre description]
 * @return [type] [description]
 */
function pre()
{
    call_user_func_array(array('u','pre'), func_get_args());
}

/**
 * predie
 * @return [type] [description]
 */
function predie()
{
    call_user_func_array(array('u','predie'), func_get_args());
}

/**
 * [k description]
 * @return [type] [description]
 */
function k()
{
    call_user_func_array(array('u','k'), func_get_args());
}