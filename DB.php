<?php

/**
 * Description of DB
 *
 * @author DOIT
 */
class DB {

    static private $instance;
    static private $connectSourse;
    private $DBConfig = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'admin',
        'database' => 'ots'
    );

    private function __construct() {
        
    }

    static public function getInstance() {     //单例模式使用
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
/**
 * 
 * @return type
 */
    public function connect() {
        if (!self::$connectSourse) {
            self::$connectSourse = mysql_connect($this->DBConfig['host'], $this->DBConfig['user'], $this->DBConfig['password']);
            if (!self::$connectSourse) {
                //die('mysql connect error' . mysql_error());
                throw new Exception('mysql connect error' . mysql_error());
            }
            mysql_select_db($this->DBConfig['database'], self::$connectSourse);
            mysql_query('set names utf8', self::$connectSourse);
        }

        return self::$connectSourse;
    }

}
//$connect=DB::getInstance()->connect();
//var_dump($connect);
//
//$sql="select * from t_user";
//$result=mysql_query($sql,$connect);
//var_dump($result);

