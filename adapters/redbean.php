<?php
/**
     * Readbean implementation
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @description :
     * @comments : http://www.redbeanphp.com
*/
require_once DIR_ADAPTERS. DS. 'redbean'.DS.'rb'.EXT_PHP;

if (ZE_DBTYPE == 'sqlite') {
    R::setup(ZE_DBTYPE.':'.ZE_DBNAME);

} else {
    R::setup(ZE_DBTYPE.':host='.ZE_DBHOST.';dbname=' .ZE_DBNAME, ZE_DBUSER, ZE_DBPASSWORD);
}

if (!class_exists('a_db')) {
    class a_db extends R
    {

        function __construct()
        {

        }

        static function info()
        {
            $info = new c_info();

            return $info->output();
        }

        static function table()
        {
            $aArgs = func_get_args();

            return call_user_func_array('ORM::for_table', $aArgs);
        }

        static function query()
        {
            $aArgs = func_get_args();
            $nbArgs = func_num_args();

            if ( preg_match('/select/i', $a[0])) {
                $aReturn = R::getAll($a[0]);
            } else {
                $aReturn = R::exec($a[0]);
            }

            return $aReturn;
        }

        static function findOne()
        {
            $aArgs = func_get_args();
            $nbArgs = func_num_args();

            switch (true) {
                case ($nbArgs == 1):
                    return R::findOne($aArgs[0]);
                break;
                case ($nbArgs == 2):
                    return R::findOne($aArgs[0], $aArgs[1]);
                break;
                case ($nbArgs == 3):
                    return R::findOne($aArgs[0], $aArgs[1], $aArgs[2]);
                break;
            }
        }

    }

    class a_dbModel extends RedBean_SimpleModel
    {

    }

    class a_table extends a_db
    {
        private $_orm;

        function __construct($sTable)
        {
            $_orm = new a_orm();

            return $_orm->toORM();
        }

        static function query()
        {
            $a = func_get_args();

            if ( preg_match('/select/i', $a[0])) {
                return R::getAll($a[0]);
            } else

                return R::exec($a[0]);

        }
    }

    class a_record extends a_db
    {
        private $_orm;

        function __construct($sTable)
        {
            $_orm = new a_orm();

            return $_orm->toORM();
        }

        static function query()
        {
            $a = func_get_args();

            if ( preg_match('/select/i', $a[0])) {
                return R::getAll($a[0]);
            } else

                return R::exec($a[0]);

        }

        public function save()
        {
            $a = func_get_args();

            if ( preg_match('/select/i', $a[0])) {
                return R::getAll($a[0]);
            } else

                return R::exec($a[0]);

        }

        public function saveNew()
        {
            $a = func_get_args();

            if ( preg_match('/select/i', $a[0])) {
                return R::getAll($a[0]);
            } else

                return R::exec($a[0]);

        }

    }
} else {
    c_debug::info('a_db class is already declared');
}
