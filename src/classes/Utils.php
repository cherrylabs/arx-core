<?php namespace Arx\classes;

/**
 * Utils
 * PHP File - /classes/utils.php
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Utils
 */
class Utils extends Singleton
{

    // --- Public methods

    public static function alias($aliasName, $callback) {
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
    } // alias


    public static function benchIt() {
        if (function_exists('xdebug_time_index')) {
            return xdebug_time_index();
        } else {
            return microtime();
        }
    } // benchIt


    public static function curlGet($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);

        return $return;
    } // curlGet


    public function findCaller($mVar) {
        if (is_string($mVar)) {
            $aQuery = array('function' => $mVar);
        } elseif (is_array($mVar)) {
            $aQuery = $mVar;
        }

        $aErrors = debug_backtrace();

        foreach ($aErrors as $key => $error) {
            if (array_intersect($error, $aQuery) == $aQuery && !empty($error['line']) && !empty($error['file'])) {
                $line = $error['line'];
                $file = $error['file'];
                return $error;
            }
        }
    } // findCaller


    public function findCallers($functionName){
        $aErrors = debug_backtrace();
        $aResult = array();

        foreach ($aErrors as $key => $error) {
            if ($error['function'] == $functionName && !empty($error['line']) && !empty($error['file'])) {
                $line = $error['line'];
                $file = $error['file'];
                $aResult[] = $error;
            }
        }

        return $aResult;
    } // findCallers


    public static function getContents($file) {
        return self::curlGet(self::getURL($file));
    } // getContents


    public static function getHeight($image) {
        $sizes = getimagesize($image);
        $height = $sizes[1];

        return $height;
    } // getHeight


    public static function getJSON($file, $as_array = false) {
        if (!empty($file)) {
            return json_decode(@file_get_contents(u::getURL($file)), $as_array);
        }

        return false;
    } // getJSON


    public static function getVideoEmbed($url, $width = 560, $height = 315) {
        switch (true) {
            case preg_match('/youtu/i', $url):
                $url_string = parse_url($url, PHP_URL_QUERY);
                parse_str($url_string, $args);
                $id = isset($args['v']) ? $args['v'] : false;

                if (!empty($id)) {
                    return '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
                }

                return false;

            case preg_match('/vimeo/i', $url):
                // sscanf(parse_url($url, PHP_URL_PATH), '/%d', $id);
                $id = filter_var($url, FILTER_SANITIZE_NUMBER_INT);

                if (!empty($id)) {
                    return '<iframe src="http://player.vimeo.com/video/'.$id.'?portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                }

                return false;

            case preg_match('/dailymotion/i', $url):
                $id = str_replace('/video/', '', parse_url($url, PHP_URL_PATH));

                if (!empty($id)) {
                    return '<iframe frameborder="0" width="'.$width.'" height="'.$height.'" src="http://www.dailymotion.com/embed/video/'.$id.'"></iframe>';
                }

                return false;
        }
    } // getVideoEmbed


    public static function getWidth($image) {
        $sizes = getimagesize($image);
        $width = $sizes[0];

        return $width;
    } // getWidth


    public static function header($type) {
        include_once(__DIR__.DS.'utils'.DS.'header.php');

        header($aHeader[$type]);
    } // header


    public static function issetOr($sValue, $defaultValue = null){

        if (($sValue = strstr($sValue, '$')) !== false) {
            $sValue = substr($sValue, 1);
        }

        if(isset(${$sValue})){
            return $sValue;
        } else {
            return $defaultValue;
        }
    }


    public static function json_die($array) {
        header("content-type: application/json");
        die(json_encode($array, true));
    } // json_die


    public static function k($string = '') {
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
    } // k


    public static function pre() {
        $aArgs = func_get_args();

        foreach ($aArgs as $key => $value) {
            echo self::epre($value);
        }
    } // pre


    public static function predie() {
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
    } // predie


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
    public static function put_json($dest, $value, $type = false) {
        return @file_put_contents($dest, json_encode($value));
    } // put_json


    public static function randGen($numb = 10, $c = '') {
        if (!is_array($c)) {
            $c = json_decode($c, true);
        }

        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        if ($c['with'] == 'specialchars') {
            $chaine .= "éâ'`,!('&#$*^";
        }

        if (!empty($c['add'])) {
            $chaine .= $c['add'];
        }

        if (!empty($c['only'])) {
            $chaine = $c['only'];
        }

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'];
    } // randGen

    public static function randString($numb = 10, $c = '') {
        if (!is_array($c)) {
            $c = json_decode($c, true);
        }

        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        if ($c['with'] == 'specialchars') {
            $chaine .= "éâ'`,!('&#$*^";
        }

        if (!empty($c['add'])) {
            $chaine .= $c['add'];
        }

        if (!empty($c['only'])) {
            $chaine = $c['only'];
        }

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'];
    } // randString

    public static function randNum($numb = 10, $c = '') {
        if (!is_array($c)) {
            $c = json_decode($c, true);
        }

        $chaine = '0123456789';

        if ($c['with'] == 'specialchars') {
            $chaine .= "éâ'`,!('&#$*^";
        }

        if (!empty($c['add'])) {
            $chaine .= $c['add'];
        }

        if (!empty($c['only'])) {
            $chaine = $c['only'];
        }

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'];
    } // randNum

    public static function randEmail($numb = 10, $c = '') {
        if (!is_array($c)) {
            $c = json_decode($c, true);
        }

        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

        if ($c['with'] == 'specialchars') {
            $chaine .= "éâ'`,!('&#$*^";
        }

        if (!empty($c['add'])) {
            $chaine .= $c['add'];
        }

        if (!empty($c['only'])) {
            $chaine = $c['only'];
        }

        if (!empty($c['domain'])) {
            $domain = $c['domain'];
        } else {
            $domain = substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).'.com';
        }

        return $c['prepend'].substr(str_shuffle(str_repeat($chaine, $numb)), 0, $numb).$c['append'].'@'.$domain;
    } // randEmail

    public static function randArray($a, $c = '') {
        if (!is_array($c)) {
            $c = json_decode($c, true);
        }

        if (!empty($c['num'])) {
            for ($i = 1; $i <= $c['num']; $i++) {
                $r .= $c['prepend'].$a[array_rand($input, 1)].$c['append'];
            }

            return $r;
        } else {
            return $a[array_rand($a, 1)];
        }
    } // randArray


    public static function removeSVN($dir) {
        $out = array();

        $out[] = "Searching: $dir\n\t";

        $flag = false; // haven't found .svn directory
        $svn = $dir . '.svn';

        if (is_dir($svn)) {
            if (!chmod($svn, 0777)) {
                $out[] = "File permissions could not be changed (this may or may not be a problem--check the statement below).\n\t"; // if the permissions were already 777, this is not a problem
            }

            self::removeTree( $svn ); // remove the .svn directory with a helper function

            if (is_dir($svn)) {// deleting failed
                $out[] = "Failed to delete $svn due to file permissions.";
            } else {
                $out[] = "Successfully deleted $svn from the file system.";
            }

            $flag = true; // found directory
        }

        if (!$flag) {// no .svn directory
            $out[] = 'No .svn directory found.';
        }

        $out[] = "\n\n";

        $handle = opendir( $dir );

        while (false !== ($file = readdir($handle))) {
            if ($file == '.' || $file == '..') {// don't get lost by recursively going through the current or top directory
                continue;
            }

            if (is_dir($dir . $file)) {
                self::removeSVN( $dir . $file . '/' ); // apply the SVN removal for sub directories
            }
        }

        return $out;
    } // removeSVN


    public static function removeTree($dir) {
        $files = glob( $dir . '*', GLOB_MARK ); // find all files in the directory

        foreach ($files as $file) {
            if (substr($file, -1) == '/') {
                self::removeTree($file); // recursively apply this to sub directories
            } else {
                unlink($file);
            }
        }

        if (is_dir($dir)) {
            rmdir( $dir ); // remove the directory itself (rmdir only removes a directory once it is empty)
        }
    } // removeTree


    public static function resizeImage($image, $width, $height, $scale) {
        $newImageWidth = ceil($width*$scale);
        $newImageHeight = ceil($height*$scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $ext = pathinfo($image, PATHINFO_EXTENSION);

        switch ($ext) {
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
    } // resizeImage


    public static function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale) {
        $newImageWidth = ceil($width*$scale);
        $newImageHeight = ceil($height*$scale);
        $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $source = imagecreatefromjpeg($image);
        imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height);
        imagejpeg($newImage, $thumb_image_name, 90);
        chmod($thumb_image_name, 0777);

        return $thumb_image_name;
    } // resizeThumbnailImage


    /**
     * SendEmail
     * @param $recipient
     * @return
     * @todo make more customisable !
     */
    public static function sendMail($recipient, $subject = null, $html, $c = null) {
        $c = u::toArray($c);
        $headers = 'From: '.stripslashes($c['exp_nom']).' <'.$c['exp_mail'].'>' . "\r\n";
        $headers .= 'MIME-version: 1.0'."\n";
        $headers .= 'Content-type: text/html; charset=UTF-8'."\n";
        $headers .= 'Reply-To: '.$c['exp_mail']. "\r\n";
        $success = mail($recipient, '=?UTF-8?B?'.base64_encode($subject).'?=', stripslashes($html), $headers);

        return $success;
    } // sendMail

} // class::Utils

class u extends Utils {} // Aliases
