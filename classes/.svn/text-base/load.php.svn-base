<?php
/**
 * c_load class
 *
 * @author Daniel Sum <daniel@cherrylabs.net>
 * @link http://www.cherrylabs.net
 * @copyright Copyright &copy; 2010-2012 cherrylabs.net
 * @license http://www.cherrylabs.net/licence
 * @package arx
 * @since 1.0
 */
require_once DIR_CLASSES . DS . 'filemanager.php';
require_once DIR_CLASSES . DS . 'utils.php';

class c_load
{
    private $sJs, $root, $key, $add, $sCSS;

    public static function loadAll()
    {
        echo self::loadCSS();
        echo self::loadJS();
    } // loadAll

    /**
     * Load PHP files
     * @author Daniel Sum
     */
    public static function loadPHP($sFiles = 'all', $mContext = array())
    {
        $mContext = u::toArray($mContext);

        $root = '';

        switch (true) {
            case (is_array($sFiles)):
                $sFiles = $sFiles;
                break;

            case (is_file($sFiles)):
                $sFiles = array($sFiles);
                break;

            case (is_dir($sFiles)):
                $sFiles = c_fm::find($sFiles, '*.php');
                break;
        }

        if (!array($sFiles)) {
            //if a context root is set
            if (isset($mContext['root']) && $mContext['root'] == '-') {
                $root = '';
            } elseif (!empty($mContext['root'])) {
                $root = $mContext['root'];
            //else load from default INC repository
            } else {
                $root = DIR_INC;
            }

            if (!is_array($sFiles)) {
                $sFiles = explode(',', str_replace(' ','', $sFiles));
            }
        }

        if(is_array($sFiles))
        {
            foreach ($sFiles as $sFp) {
                $sFp = $root . $sFp;

                if (!file_exists($sFp) OR is_dir($sFp)) {
                    throw new Exception('The specified file ' . $sFp . ' cannot be found!');
                } else {
                    require_once $sFp;
                }
            }

            return true;
        }

        return false;
    } // loadPHP

    public static function PHP($sFiles = 'all' , $mContect = array())
    {
        self::loadPHP($sFiles, $mContect);
    } // PHP (alias of loadPHP)

    /**
     * Load JS scripts
     * @author Daniel Sum
     */
    public static function loadJS($sFiles = 'all' , $mContext = array())
    {
        $mContext = u::toArray($mContext);

        if ($sFiles == 'all') {
            if (!empty($mContext['root'])) {
                $sFiles = c_fm::findIn($mContext['root'], array('dir' => JS));
            } else {
                $appJs = c_fm::findIn(DIR_APPS, array('pattern' => '*/js/*.js'));

                $sFiles = c_fm::findIn('', array('dir' => JS));

                if (count($appJs) > 0) {
                    // ...
                }
            }
        }

        if (!is_array($sFiles)) {
            $sFiles = explode(',', str_replace(' ','', $sFiles));
        }

        foreach ($sFiles as $sFp) {
            $sFp = u::getUrlFile($sFp);

            if (!strpos($sFp, '.only.') && !strpos($sFp, '.not.') && strpos($sFp, '.js')) {
                $sJs .= '<script type="text/javascript" src="' . $sFp . '"></script>' . "\r\n";
                c_hook::js($sCSS);
            }
        }

        if (!empty($mContext['cat'])) {
            foreach ($sFiles as $sFp) {
                if (strpos($sFp, $mContext['cat'])) {
                    $sJs .= '<script type="text/javascript" src="' . $sFp . '"></script>' . "\r\n";
                }
            }
        }

        return $sJs;
    } // loadJS

    public static function js($sFiles = 'all' , $mContext = array())
    {
        return self::loadJS($sFiles, $mContext);
    } // js (alias of loadJS)

    /**
     * Load CSS scripts
     * @author Daniel Sum
     */
    public static function loadCSS($sFiles = 'all' , $mContext = array())
    {
        $sCSS = null;

        $mContext = u::toArray($mContext);

        if ($sFiles == 'all') {
            if (!empty($mContext['root'])) {
                $sFiles = c_fm::findIn($mContext['root'], array('dir' => CSS));
            } else {
                $sFiles = $GLOBALS['allCSS'];
            }
        }

        //if a context root is set
        if (!empty($mContext['root'])) {
            $root = $mContext['root'];
        } else {
        //else load from default CSS repository
            $root = DIR_CSS;
        }

        if (!is_array($sFiles)) {
            $sFiles = explode(',', str_replace(' ','', $sFiles));
        }

        //preventdefault exclude
        $mContext['exclude'][] = '.not.';

        foreach ($sFiles as $key=>$sFp) {
            $sFp = u::getUrlFile($sFp);

            if (!in_array(str_replace(CSS.DS,'',$sFp), $mContext['exclude'])) {

                if ( !isset($mContext['add']) ) {
                    $mContext['add'] = '';
                }

                if (strpos($sFp, '.print.')) {
                    $sCSS .= '<link rel="stylesheet" media="print" href="'. $sFp .'" type="text/css" '. (!empty($mContext['add'][$key]) ? $mContext['add'][$key] : $mContext['add']) .' />  '."\r\n";
                } elseif (strpos($sFp, '.css')) {
                    $sCSS .= '<link rel="stylesheet"  href="'. $sFp .'" type="text/css" '. (!empty($mContext['add'][$key]) ? $mContext['add'][$key] : $mContext['add']) .' />'."\r\n";
                }
                //c_hook::css($sCSS);

            }
        }

        return $sCSS;

    } // loadCSS

    public static function CSS($sFiles = 'all' , $mContext = array())
    {
        return self::loadCSS($sFiles, $mContext);
    } // CSS (alias of loadCSS)

    
} // class::c_load
