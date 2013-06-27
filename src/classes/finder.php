<?php namespace Arx;
/**
    * File explorer Class
    * @file
    *
    * @package
    * @author Daniel Sum
    * @link 	@endlink
    * @see
    * @description
    *
    * @code 	@endcode
    * @comments
    * @todo
*/

class c_finder
{

    private $_path = "";

    private $_exclude_extension = array('entries', 'all-wcprops', 'DS_Store');
    private $_exclude_file = array('.DS_Store', 'all-wcprops', 'DS_Store');
    private $_exclude_dir = array('.svn', 'all-wcprops', 'DS_Store');

    /********************* CONSTRUCT *********************/

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        return $this;
    }

    public function __get($file)
    {
        $file = $this->_path.DS.$file;

        return new self($file);

    }

    public function open($file)
    {
        $file = $this->_path.DS.$file;

        return new self($file);

    }

    /********************* PRIVATE *********************/

        /**
     * Get extension from a string
     *
     * @access private
     * @param  string $file
     * @return string
     */
    private function getExtension($file)
    {
        $parts = explode(".", $file);

        return end($parts);
    }

    /**
     * Sort an arry based on the strings length
     *
     * @access private
     * @param  string $val_1
     * @param  string $val_2
     * @return int
     */
    private function lengthSort($val_1, $val_2)
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

    }

    /********************* PUBLIC **********************/

    /**
     * Set the explorer path
     *
     * @access public
     * @param  string $path
     * @return void
     */
    public function setPath($path="")
    {
        if ($path != "") {
            $this->_path = str_replace("\\", DS, $path);
            $this->_path = (substr($this->_path, -1) == DS) ? substr($this->_path, 0, -1) : $this->_path;
        }
    }

    /**
     * Read file content
     *
     * @access public
     * @param  string $filename
     * @return string
     */
    public function read()
    {
        $handle = fopen($this->_path, "r");
        $contents = fread($handle, filesize($this->_path));
        fclose($handle);

        return $contents;
    }

    /**
     * Write content to file
     *
     * @access public
     * @param  string $filename
     * @param  string $data
     * @return bool
     */
    public function save($data)
    {
        if ($handle = fopen($this->_path,"w")) {
            fwrite($handle, $data);
            fclose($handle);

            return true;
        }

        return false;
    }

    /**
     * Create file
     *
     * @access public
     * @param  bool $is_dir
     * @param  bool $create_if_exists If true existing file is overwrited
     * @return bool
     */
    public function create($is_dir=false, $create_if_exists=false)
    {
        if(file_exists($this->_path) && !$create_if_exists) return false;
        if (!$is_dir) {
            $parts = explode(DS, $this->_path);
            $path = "";
            foreach ($parts as $part) {
                if($part == end($parts)) break;
                $path .= $part . DS;
                @mkdir($path, "0700");
            }
            if ($handle = fopen($this->_path, 'w')) {
                fclose($handle);
            }
        } else {
            $parts = explode(DS, $this->_path);
            $path = "";
            foreach ($parts as $part) {
                $path .= $part . DS;
                @mkdir($path, "0700");
            }
        }

        return file_exists($this->_path);
    }

    /**
     * Delete a file or directory
     *
     * @access public
     * @return bool
     */
    public function delete()
    {
        if (is_dir($this->_path) && $this->_path != "") {
            $result = $this->scan();

            // Bring maps to back
            // This is need otherwise some maps
            // can't be deleted
            $sort_result = array();
            foreach ($result as $item) {
                if ($item['type'] == "file") {
                    array_unshift($sort_result, $item);
                } else {
                    $sort_result[] = $item;
                }
            }

            // Start deleting
            while (file_exists($this->_path)) {
                if (is_array($sort_result)) {
                    foreach ($sort_result as $item) {
                        if ($item['type'] == "file") {
                            @unlink($item['fullpath']);
                        } else {
                            @rmdir($item['fullpath']);
                        }
                    }
                }
                @rmdir($this->_path);
            }

            return !file_exists($this->_path);
        } else {
            @unlink($this->_path);

            return !file_exists($this->_path);
        }
    }

    /**
     * Copy directory's or files
     *
     * @access public
     * @param  string $destination
     * @return bool
     */
    public function copy($destination)
    {
        if($destination == "") throw new Exception("Destination is not specified.");

        $destination = str_replace("\\", DS, $destination);
        $destination = (substr($destination, -1) == DS) ? substr($destination, 0, -1) : $destination;
        if (is_dir($this->_path)) {

            // Create paths recursively
            $result = $this->scan();
            $paths = array();
            $files = array();
            foreach ($result as $item) {
                if ($item["type"] == "dir") {
                    $paths[] = str_replace($this->_path, "", $item['fullpath']);
                } else {
                    $file = str_replace($this->_path, "", $item['fullpath']);
                    $files[] = (substr($file, 0, 1) == DS) ? $file : DS . $file;
                }
            }
            uasort($paths, array($this, "lengthSort"));

            // Create directory structure
            foreach ($paths as $path) {
                $path = (substr($path, 0, 1) == DS) ? $path : DS . $path;
                $new_directory = $destination . $path;
                @mkdir($destination);
                if (!file_exists($new_directory)) {
                    @mkdir($new_directory, "0700");
                }
            }

            // Copy files
            foreach ($files as $file) {
                @copy($this->_path . $file, $destination . $file);
            }

            return file_exists($destination);
        } else {
            @copy($this->_path, $destination);

            return file_exists($destination);
        }

    }

    /**
     * Move directory or file
     *
     * @access public
     * @param string $destination
     * @access void
     */
    public function move($destination)
    {
        $this->Copy($destination);
        $this->Delete();

        return (file_exists($destination) && !file_exists($this->_path));
    }

    /**
     * List directory content
     *
     * @access public
     * @param  array $exclude
     * @param  bool  $recursive
     * @return array
     */
    public function scan($c = true, &$list=array(), $exclude_extension = array(), $exclude_file=array(), $exclude_dir=array(), $dir="")
    {
        if (is_array($c)) {
            foreach ($c as $key=>$item) {
                ${$key} = $item;
            }
        } else {
            $recursive = $c;
        }

        if(!$exclude_extension) $exclude_extension = $this->_exclude_extension;
        if(!$exclude_file) $exclude_file = $this->_exclude_file;
        if(!$exclude_dir) $exclude_dir = $this->_exclude_dir;

        // Lowercase exclude arrays
        $exclude_extension = array_map("strtolower", $exclude_extension);
        $exclude_file = array_map("strtolower", $exclude_file);
        $exclude_dir = array_map("strtolower", $exclude_dir);

        $dir = ($dir == "") ? $this->_path : $dir;
        if(substr($dir, -1) != DS) $dir .= DS;

        // Open the folder
        $dir_handle = @opendir($dir) or die("Unable to open $dir");

        // Loop through the files
        while ($file = readdir($dir_handle)) {

            // Strip dir pointers and extension exclude
            $extension = $this->getExtension($file);
            if($file == "." || $file == ".." || in_array($extension, $exclude_extension)) continue;

            if (is_dir($dir . $file)) {
                if (!in_array(strtolower($file), $exclude_dir)) {
                    $info				= "";
                    $info["type"]		= "dir";
                    $info["path"]		= $dir;
                    $info["fullpath"]	= $dir . $file;
                    $info["urlpath"]	= str_replace(ROOT_DIR, ROOT_URL, $info["fullpath"]);
                    $info["name"]	= str_replace($dir, '', $info["fullpath"]);
                    $list[] = $info;
                }
            } else {
                if (!in_array(strtolower($file), $exclude_file)) {
                    $info				= "";
                    $info["extension"] = $extension;
                    $info["type"]		= "file";
                    $info["path"]		= $dir;
                    $info["filename"]	= $file;
                    $info["fullpath"]	= $dir . $file;
                    $info["urlpath"]	= str_replace(ROOT_DIR, ROOT_URL, $info["fullpath"]);
                    $info["name"]	= str_replace('.'.$extension, '', $file);
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

    }

    /**
     * List directory content
     *
     * @access public
     * @param  array $exclude
     * @param  bool  $recursive
     * @return array
     * @TODO : function more generic
     */
    public function scan_only($c = true, &$list=array(), $exclude_extension = array(), $exclude_file=array(), $exclude_dir=array(),   $dir="")
    {
        $aFiles = $this->scan($c, $list, $exclude_extension, $exclude_file, $exclude_dir, $dir);

        $list = array();

        foreach ($aFiles as $key=>$v) {

            if (isset($c['extension']) && preg_match('/'.$c['extension'].'/i', $v['extension'])) {
                $list[$key] = $v;
            }

            if (isset($c['type']) && preg_match('/'.$c['type'].'/i', $v['type'])) {
                $list[$key] = $v;
            }

        }

        return $list;

    }

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
    }

    /**
     * Get path
     *
     * @access public
     * @return string
     */
    public function get_path()
    {
        return $this->get_dir().DS;
    }

    /**
     * Get path
     *
     * @access public
     * @return string
     */
    public function get_dir()
    {
        return $this->_path;
    }
}
