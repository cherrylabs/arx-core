<?php namespace Arx\traits;

use Api;
use Arx\classes\Arr;
use Arx\classes\Image;
use Exception, File;
use Input;

trait modelFilesHandlingTrait {


    public static $filepath = null;

    /**
     * Check if folders exists
     */
    public function getCurrentPath()
    {

        // if no filepath defined => autocreate path from table name
        if(!static::$filepath){
            static::$filepath = "files/".$this->getTable();
        }

        static::$currentPath = public_path(static::$filepath.'/' . $this->id);

        if (!is_dir(static::$currentPath)) {
            try {
                @mkdir(static::$currentPath, 0777, true);
            } catch (Exception $e) {
                Api::handleError($e);
            }
        }

        return static::$currentPath;
    }

    /**
     * Filepath
     *
     * @param $path
     * @return string
     */
    public function path($path = null)
    {
        return $this->getCurrentPath() . '/' . $path;
    }

    /**
     * Get Relative path start from /public/
     *
     * @param null $path
     * @return mixed
     */
    public function relPath($path = null)
    {
        # Cleaning path
        $path = preg_replace('/^\//', '', $path);

        return str_replace(public_path(), '', $this->getCurrentPath().'/'.$path);
    }

    /**
     * Upload method helper
     *
     * @param null $name
     * @param null $file
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function upload($name = null, $file = null, $params = ['path' => '','afterUpload' => null, 'beforeUpload' => null, 'coords' => null, 'width' => null, 'height' => null, 'beforeUploadImage' => null]){

        Arr::mergeWithDefaultParams($params);

        $data = [];

        if($file){
            $data['file'] = $file;
        } elseif(Input::hasFile('file')){
            $data['file'] = Input::file('file');
        }   else {
            trigger_error("File doesn't exist.");
        }

        $data['name'] = $name;

        $data['params'] = $params;

        $data['response'] = false;

        $data['path'] = $this->relPath();

        $data['fullname'] = $data['file']->getClientOriginalName();

        $data['extension'] = $data['file']->getExtension() ?: $data['file']->getClientOriginalExtension();
        $data['mimeType'] = $data['file']->getMimeType();

        if(in_array($data['mimeType'], ['image/gif', 'image/jpeg', 'image/png'])){
            $data['type'] = "image";
        } else {
            $data['type'] = "file";
        }

        if(!$data['name']){
            $data['name'] = $data['file']->getClientOriginalName();
        } elseif(strpos($data['name'], '.') && !preg_match('/\.'.$data['extension'].'$/i', $data['name'])){
            $data['convert'] = true;
        } elseif(!strpos($data['name'], '.')){
            $data['name'] = $data['name'] . '.' . $data['extension'];
        }

        if($params['beforeUpload']){
            $data = $params['beforeUpload']($data);
        }

        if ($params['path']) {
            try {
                if(!is_dir(public_path($data['path'].$params['path'])))
                    mkdir(public_path($data['path'].$params['path']), 0777, true);
            } catch (Exception $e) {
                Api::handleError($e);
                return Api::responseJsonError($e);
            }
        }


        if($data['type'] == 'image'){

            $img = Image::load($data['file']->getRealPath());

            if($data['params']['coords']){
                $coords = $data['params']['coords'];
                if (!is_array($coords)) {
                    $coords = json_decode(stripslashes($coords), true);
                }
                $img->crop($coords['x'], $coords['y'], $coords['x'] + $coords['w'], $coords['y'] + $coords['h']);
            } elseif($data['params']['width'] && $data['params']['height']) {
                $img->resize($data['params']['width'], $data['params']['height']);
            } elseif($data['params']['width']){
                $img->fit_to_width($data['params']['width']);
            } elseif($data['params']['height']) {
                $img->fit_to_width($data['params']['height']);
            }

            if($params['beforeUploadImage']){
                $img = $params['beforeUploadImage']($img);
            }

            $data['response'] = $img->save(public_path($data['path'] .$params['path']. $data['name']));

        } else {

            $data['response'] = File::move($data['file']->getRealPath(), $data['path'] .$params['path']. $data['name']);
        }

        if($params['afterUpload']){
            $data = $params['afterUpload']($data);
        }

        if (isset($data['path'], $data['name'])) {
            $data['relpath'] = self::cleanPath($data['path'] . $data['name']);
        }

        return $data;
    }

    /**
     * Clean path handler
     *
     * @param $path
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public static function cleanPath($path, $params = ['checkDir' => false, 'checkFile' => false]){

        $params = Arr::mergeWithDefaultParams($params);

        if($params['checkDir']){
            if(!is_dir($path)){
                Throw new Exception('Path is not a dir');
            }
        }

        if($params['checkFile']){
            if(!is_file($path)){
                Throw new Exception('Path is not a file');
            }
        }

        return str_replace(array('//'), array('/'), $path);
    }

}