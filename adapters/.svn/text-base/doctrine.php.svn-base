<?php

if (ZE_DBTYPE == 'sqlite') {

    Doctrine_Manager::configure(ZE_DBTYPE.':'.ZE_DBNAME);
    Doctrine_Manager::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.ZE_DBCHARSET));

} else {
    Doctrine_Manager::configure(ZE_DBTYPE.':host='.ZE_DBHOST.';dbname='.ZE_DBNAME);

    Doctrine_Manager::configure('username', ZE_DBUSER);

    Doctrine_Manager::configure('password', ZE_DBPASSWORD);

    Doctrine_Manager::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.ZE_DBCHARSET));
}