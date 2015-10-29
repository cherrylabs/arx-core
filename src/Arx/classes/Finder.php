<?php namespace Arx\classes;

use Symfony\Component\Finder\Finder as ParentClass;

use Symfony\Component\Finder\Adapter\AdapterInterface;
use Symfony\Component\Finder\Adapter\GnuFindAdapter;
use Symfony\Component\Finder\Adapter\BsdFindAdapter;
use Symfony\Component\Finder\Adapter\PhpAdapter;
use Symfony\Component\Finder\Exception\ExceptionInterface;

/**
 * Finder Class
 *
 * Usefull file explorer class to navigate easily inside folder
 *
 * @example
 *
 * $finder = new Finder('path');
 *
 * $finder->workbench->scan(); # where folder is a folder
 *
 * @category Utils
 * @package  Arx
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Finder
 */
class Finder extends ParentClass
{

    // --- Constants


    // --- Public members


    // --- Protected members


    // --- Private members

    private $_path = "";
    private $_exclude_extension = array('entries', 'all-wcprops', 'DS_Store');
    private $_exclude_file = array('.DS_Store', 'all-wcprops', 'DS_Store', '.gitkeep', '.gitignore');
    private $_exclude_dir = array('.svn', 'all-wcprops', 'DS_Store', '.git', '.idea');


    // --- Magic methods

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct($path = null)
    {
        if ($path) {
            $this->setPath($path);
            parent::__construct($path);
        }

    } // __construct

    public function __get($file)
    {
        $file = $this->_path . DS . $file;

        return new self($file);

    } // __get

    public function __set($sName, $mValue)
    {
    } // __set}

    public static function dir($path)
    {
        return new self($path);
    }

    public static function instance($path = null){
        return new self($path);
    }


    // --- Public methods

    public function open($file)
    {
        $file = $this->_path . DS . $file;

        return new self($file);

    } // open

    /**
     * Set the explorer path
     *
     * @access public
     *
     * @param  string $path
     *
     * @return void
     */
    public function setPath($path = "")
    {
        if ($path != "") {
            $this->_path = str_replace("\\", DS, $path);
            $this->_path = (substr($this->_path, -1) == DS) ? substr($this->_path, 0, -1) : $this->_path;
        }
    } // setPath

    /**
     * List directory content
     *
     * @access public
     *
     * @param  array $exclude
     * @param  bool  $recursive
     *
     * @return array
     */
    public function scan($c = true, &$list = array(), $exclude_extension = array(), $exclude_file = array(), $exclude_dir = array(), $dir = "")
    {
        if (is_array($c)) {
            foreach ($c as $key => $item) {
                ${$key} = $item;
            }
        } else {
            $recursive = $c;
        }

        if (!$exclude_extension) $exclude_extension = $this->_exclude_extension;
        if (!$exclude_file) $exclude_file = $this->_exclude_file;
        if (!$exclude_dir) $exclude_dir = $this->_exclude_dir;

        // Lowercase exclude Arr
        $exclude_extension = array_map("strtolower", $exclude_extension);
        $exclude_file = array_map("strtolower", $exclude_file);
        $exclude_dir = array_map("strtolower", $exclude_dir);

        $dir = ($dir == "") ? $this->_path : $dir;
        if (substr($dir, -1) != DS) $dir .= DS;

        // Open the folder
        $dir_handle = @opendir($dir) or die("Unable to open $dir");

        // Loop through the files
        while ($file = readdir($dir_handle)) {

            // Strip dir pointers and extension exclude
            $extension = $this->getExtension($file);
            if ($file == "." || $file == ".." || in_array($extension, $exclude_extension)) continue;

            if (is_dir($dir . $file)) {
                if (!in_array(strtolower($file), $exclude_dir)) {
                    $info = "";
                    $info["type"] = "dir";
                    $info["path"] = $dir;
                    $info["fullpath"] = $dir . $file;
                    $info["urlpath"] = str_replace(Config::get('paths.root'), Config::get('paths.rooturl'), $info["fullpath"]);
                    $info["name"] = str_replace($dir, '', $info["fullpath"]);
                    $list[] = $info;
                }
            } else {
                if (!in_array(strtolower($file), $exclude_file)) {
                    $info = "";
                    $info["extension"] = $extension;
                    $info["type"] = "file";
                    $info["path"] = $dir;
                    $info["filename"] = $file;
                    $info["fullpath"] = $dir . $file;
                    $info["urlpath"] = str_replace(Config::get('paths.root'), Config::get('paths.rooturl'), $info["fullpath"]);
                    $info["name"] = str_replace('.' . $extension, '', $file);
                    $list[] = $info;
                }
            }

            if ($recursive && is_dir($dir . $file) && !in_array(strtolower($file), $exclude_dir)) {
                $this->scan($recursive, $list, $exclude_extension, $exclude_file, $exclude_dir, $dir . $file);
            }

        }

        // Close
        closedir($dir_handle);

        return $list;
    } // scan

    /**
     * List directory content
     *
     * @access public
     *
     * @param  array $exclude
     * @param  bool  $recursive
     *
     * @return array
     * @TODO   : function more generic
     */
    public function scanOnly($c = true, &$list = array(), $exclude_extension = array(), $exclude_file = array(), $exclude_dir = array(), $dir = "")
    {
        $aFiles = $this->scan($c, $list, $exclude_extension, $exclude_file, $exclude_dir, $dir);

        $list = array();

        foreach ($aFiles as $key => $v) {

            if (isset($c['extension']) && preg_match('/' . $c['extension'] . '/i', $v['extension'])) {
                $list[$key] = $v;
            }

            if (isset($c['type']) && preg_match('/' . $c['type'] . '/i', $v['type'])) {
                $list[$key] = $v;
            }

        }

        return $list;

    } // scan_only

    /**
     * Get extension of a file
     *
     * @access public
     * @return string
     */
    public function get_extension()
    {
        if (!is_dir($this->_path)) {
            return $this->getExtension($this->_path);
        }

        return false;
    } // get_extension

    /**
     * Get path
     *
     * @access public
     * @return string
     */
    public function getPath()
    {
        return $this->getDir() . DS;
    } // get_path

    /**
     * Get path
     *
     * @access public
     * @return string
     */
    public function getDir()
    {
        return $this->_path;
    } // get_dir


    // --- Protected methods


    // --- Private methods

    /**
     * Get extension from a string
     *
     * @access private
     *
     * @param  string $file
     *
     * @return string
     */
    private function getExtension($file)
    {
        $parts = explode(".", $file);

        return end($parts);
    } // getExtension

    /**
     * Sort an array based on the strings length
     *
     * @access private
     *
     * @param  string $val_1
     * @param  string $val_2
     *
     * @return int
     */
    public static function lengthSort($val_1, $val_2)
    {
        // initialize the return value to zero
        $retVal = 0;

        // compare lengths
        $firstVal = strlen($val_1);
        $secondVal = strlen($val_2);

        if ($firstVal > $secondVal) {
            $retVal = 1;
        } elseif ($firstVal < $secondVal) {
            $retVal = -1;
        }

        return $retVal;
    } // lengthSort


} // class::Finder
