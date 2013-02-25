<?php
/**
 * @name class.db.php
 * @desc
 */
abstract class aDb
{
    public static $aErrors = array();

    private static $instance;

    private static $aConnexions = array();
    private static $sCurrentBase;

    /*--------------------------------------------------------------------------------------------------------------------------*/
    public function __construct($sBase = DB_BASE, $sHost = DB_HOST, $sUser = DB_USER, $sPass = DB_PASS)
    {
        //return $this->addConnexion($sBase, $sHost, $sUser, $sPass);
    } // __construct

    public function __destruct()
    {
        if(!empty(self::$errors))	var_dump(self::$errors);
    } // __destruct

    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    } // __clone

    /*--------------------------------------------------------------------------------------------------------------------------*/
    protected static function _parse($sQuery, $sContext = null)
    {
        $type = false;

        if (!is_null($sContext)) {
            if(!is_array($sContext))	$sContext = json_decode($sContext, true);

            foreach ($sContext as $key => $val) {
                switch ($key) {
                    case 'type':
                        if(preg_match('/array|json|xml/i', $val))	$type = true;
                        break;
                }
            }
        }

        $result = self::_query($sQuery, $type);

        if (!empty($sContext['key'])) {
            $arr = array();
            foreach ($result as $key => $val) {
                if($key === 'count')	$arr[$key] = $val;
                else if($type === true)	$arr[$result[$key][$sContext['key']]] = $val;
                else	$arr[$result[$key]->$sContext['key']] = $val;
            }
            $result = $arr;
        }

        if (!empty($sContext['type'])) {
            switch ($sContext['type']) {
                case 'json':
                    $result = json_encode($result);
                    break;
                case 'string':
                    $result = http_build_query($result);
                    break;
            }
        }

        if(isset($sContext['debug']))	die($sQuery);

        return $result;
    } // _parse

    protected static function _query($sQuery, $bArray = true)
    {
        $result = false;

        try {
            if (preg_match('/select/i', $sQuery)) {
                if($bArray)	$style = PDO::FETCH_ASSOC;
                else	$style = PDO::FETCH_CLASS;

                $query = self::getInstance()->prepare($sQuery);
                $query->execute();

                $result = $query->fetchAll($style);

                $result['count'] = $query->columnCount();
            } else {
                $result = self::getInstance()->exec($sQuery);
            }
        } catch (PDOException $e) {
            self::off();
            array_push(self::$aErrors, $e->getMessage());
        }

        return $result;
    } // _query

    /*--------------------------------------------------------------------------------------------------------------------------*/
    public static function getInstance($sBase = DB_BASE, $sHost = DB_HOST, $sUser = DB_USER, $sPass = DB_PASS)
    {
        if(strpos($sHost, 'sqlite'))	$dns = 'sqlite:' . $sHost;
        else	$dns = 'mysql:host=' . $sHost . ';dbname=' . $sBase, $sUser, $sPass;

        try {
            self::$instance = new PDO($dns, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            self::$sCurrentBase = $sBase;
        } catch (PDOException $e) {
            self::off();
            array_push(self::$aErrors, $e->getMessage());
        }

        return self::$instance;
    } // getInstance

    public static function insert($sValues, $sTable, $sContext = null)
    {
        if(!is_array($sContext))	$sContext = json_decode($sContext, true);

        $query = "INSERT INTO " . $sTable;

        //...

        //return self::_query($sQuery, $sContext);
    } // insert

    public static function query($sQuery, $sContext = null)
    {
        return self::_parse($sQuery, $sContext);
    } // query

    public static function off()
    {
        self::$instance = null;
    } // off

    public static function on($sBase = DB_BASE, $sHost = DB_HOST, $sUser = DB_USER, $sPass = DB_PASS)
    {
        return self::getInstance($sBase, $sHost, $sUser, $sPass, $sDriver);
    } // on

    public static function select($sField, $sTable, $sContext = null)
    {
        self::_parse("SELECT " . $sField . " FROM " . $sTable, $sContext);
    } // select

    /*
    public static function update($sTable, $sValues, $sContext = null)
    {
        if(!is_array($sValues))	$sValues = json_encode($sValues, true);

        //...
        return self::_query($sQuery, $sContext);
    } // update
    */

}
