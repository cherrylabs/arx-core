<?php
/**
 * An Orm über class !
 * @author Daniel Sum
 * @version 0.1
 * @package arx
 * @comments :
 */

if (ZE_DBTYPE == 'sqlite') {
    ORM::configure(ZE_DBTYPE.':'.ZE_DBNAME);
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.ZE_DBCHARSET));
} else {
    ORM::configure(ZE_DBTYPE.':host='.ZE_DBHOST.';dbname='.ZE_DBNAME);
    ORM::configure('username', ZE_DBUSER);
    ORM::configure('password', ZE_DBPASSWORD);
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.ZE_DBCHARSET));
}

if (!class_exists('a_db')) {

    class a_db extends ORM {

        public function __construct() {} // __construct

        public static function info() {
            $info = new c_info();

            return $info->output();
        } // info

        public static function table($table) {
            $aArgs = func_get_args();

            return ORM::for_table($table);
        } // table

        public static function find() {
            $aArgs = func_get_args();
            $nbArgs = func_num_args();

            switch (true) {
                case ($nbArgs == 1):
                    list($sTablename, $mConditions) = $aArgs;

                    return ORM::for_table($sTablename)->where($mConditions)->find_one();

                case ($nbArgs == 2):
                    list($sTablename, $mConditions) = $aArgs;

                    return ORM::for_table($sTablename)->where($mConditions)->find_one();

                case ($nbArgs == 3):
                    list($sTablename, $mConditions, $aCleanVars) = $aArgs;

                    return ORM::for_table($sTablename)->where($mConditions, $aCleanVars)->find_one();
            }

            return false;
        } // find

        public static function find_all() {
            $aArgs = func_get_args();
            $nbArgs = func_num_args();

            switch (true) {
                case ($nbArgs == 0):
                    list($sTablename, $mConditions) = $aArgs;

                    return ORM::for_table($sTablename)->find_all();

                case ($nbArgs == 1):
                    list($sTablename, $mConditions) = $aArgs;

                    return ORM::for_table($sTablename)->where($mConditions)->find_one();

                case ($nbArgs == 2):
                    list($sTablename, $mConditions) = $aArgs;

                    return ORM::for_table($sTablename)->where($mConditions)->find_one();

                case ($nbArgs == 3):
                    list($sTablename, $mConditions, $aCleanVars) = $aArgs;

                    return ORM::for_table($sTablename)->where($mConditions, $aCleanVars)->find_one();
            }

            return false;
        } // find_all

        private static function _update($table, $sets, $conditions, &$err) {
            $query = "UPDATE $table SET ";
            $aClean = array();
            $aSets = array();

            foreach ($sets as $key=>$value) {
                $aSets[] = "$key = :$key";
                $aClean[$key] = $value;
            }

            $query .= explode($aSets);

            return ORM::for_table($table)->raw_query($query, $aClean);
        } // _update

    } // adapter:a_db
}
